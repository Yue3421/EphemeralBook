<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Backup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BackupController extends Controller
{
    /**
     * Tampilkan daftar backup.
     */
    public function index()
    {
        $backups = Backup::latest()->paginate(15);
        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Buat backup database baru.
     */
    public function create()
    {
        try {
            // Nama file backup
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = 'backups/' . $filename;

            // Ambil semua tabel
            $tables = DB::select('SHOW TABLES');
            $sql = '';

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                
                // Drop table if exists
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n\n";
                
                // Get create table syntax
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
                $createSql = $createTable[0]->{'Create Table'};
                $sql .= $createSql . ";\n\n";
                
                // Get data
                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $columns = implode('`, `', array_keys((array)$row));
                    $values = array_values((array)$row);
                    
                    // Escape values properly using DB connection
                    $values = array_map(function($value) {
                        if (is_null($value)) return 'NULL';
                        return "'" . DB::connection()->getPdo()->quote($value) . "'";
                    }, $values);
                    
                    $valuesStr = implode(', ', $values);
                    
                    $sql .= "INSERT INTO `$tableName` (`$columns`) VALUES ($valuesStr);\n";
                }
                $sql .= "\n\n";
            }

            // Simpan ke file
            Storage::disk('local')->put($path, $sql);

            // Catat ke tabel backups
            Backup::create([
                'file_name' => $filename,
                'file_path' => $path,
                'size' => Storage::size($path),
                'created_by' => Auth::id()
            ]);

            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup database berhasil dibuat');

        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Download file backup.
     */
    public function download(Backup $backup)
    {
        if (!Storage::exists($backup->file_path)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan');
        }

        return Storage::download($backup->file_path, $backup->file_name);
    }

    /**
     * Restore database dari file backup.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_id' => 'required|exists:backups,id'
        ]);

        $backup = Backup::findOrFail($request->backup_id);

        if (!Storage::exists($backup->file_path)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan');
        }

        try {
            // Baca file SQL
            $sql = Storage::get($backup->file_path);
            
            // Validate SQL - only allow safe statements
            $dangerousPatterns = [
                '/;\s*DROP\s+/i',
                '/;\s*DELETE\s+/i',
                '/;\s*TRUNCATE\s+/i',
                '/;\s*ALTER\s+USER/i',
                '/;\s*GRANT\s+/i',
                '/;\s*REVOKE\s+/i',
            ];
            
            foreach ($dangerousPatterns as $pattern) {
                if (preg_match($pattern, $sql)) {
                    throw new \Exception('File backup mengandung perintah SQL yang tidak diizinkan');
                }
            }

            // Hapus semua tabel
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                DB::statement("DROP TABLE IF EXISTS `$tableName`");
            }
            
            // Jalankan SQL backup per statement untuk keamanan
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    DB::statement($statement);
                }
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return redirect()->route('admin.backup.index')
                ->with('success', 'Database berhasil direstore dari file: ' . $backup->file_name);

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal restore: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file backup.
     */
    public function destroy(Backup $backup)
    {
        try {
            // Hapus file
            if (Storage::exists($backup->file_path)) {
                Storage::delete($backup->file_path);
            }

            // Hapus record
            $backup->delete();

            return redirect()->route('admin.backup.index')
                ->with('success', 'File backup berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }
}
