<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use App\Models\Dataset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DatasetController extends Controller
{
    public function index()
    {
        return view('admin.manage_master.dataset.index')->with('sb', 'Dataset');
    }

    public function getall(Request $request)
    {
        $query = Dataset::select('id', 'text')
                ->orderBy('id', 'ASC');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function (Dataset $dataset) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-id="' . $dataset->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

   public function create(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|file|mimes:csv,xlsx|max:8048',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    try {
        $filePath = $request->file('file')->getRealPath();
        $fileName = $request->file('file')->getClientOriginalName();

        // Gunakan format kutip ganda agar aman untuk argumen curl
        $command = 'curl -X POST ' .
            '"https://unincarnated-larissa-nonreciprocally.ngrok-free.dev/dataset/upload?api_key=sukher" ' .
            '-H "accept: application/json" ' .
            '-H "Content-Type: multipart/form-data" ' .
            '-F "file=@' . addslashes($filePath) . ';type=application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"';

        // Jalankan curl
        $output = [];
        $returnVar = 0;
        exec($command . ' 2>&1', $output, $returnVar);

        $responseBody = implode("\n", $output);
        Log::info('message', [$responseBody, $command]);

        if ($returnVar === 0) {
            // Jika responsnya JSON, decode langsung
            $json = json_decode($responseBody, true);
            return response()->json([
                'message' => 'File berhasil diupload!',
                'response' => $json ?? $responseBody,
            ], 200);
        } else {
            return response()->json([
                'error' => 'Curl gagal dijalankan',
                'command' => $command,
                'output' => $responseBody
            ], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
}



    public function delete(Request $request)
    {
        $dataset = Dataset::findOrFail($request->id);
        $dataset->delete();
        return response()->json(['message' => 'Dataset berhasil dihapus'], 200);
    }
}