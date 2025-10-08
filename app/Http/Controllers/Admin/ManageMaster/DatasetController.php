<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use CURLFile;
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
                ->orderBy('id', 'DESC');

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
            'file' => 'required|file|mimes:csv,xlsx,xls|max:8048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            $uploadedFile = $request->file('file');
            $filePath = $uploadedFile->getRealPath();
            $fileName = $uploadedFile->getClientOriginalName();

            $cfile = new CURLFile(
                $filePath,
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                $fileName
            );

            $postData = ['file' => $cfile];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('API_URL_CHATBOT').'/dataset/upload?api_key='. env('API_KEY_CHATBOT'));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['accept: application/json']);

            $responseBody = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                return response()->json([
                    'error' => 'Curl gagal dijalankan: ' . $curlError
                ], 500);
            }

            $json = json_decode($responseBody, true);
            return response()->json([
                'message' => 'File berhasil diupload!',
                'response' => $json ?? $responseBody,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function delete(Request $request)
    {
        $dataset = Dataset::findOrFail($request->id);
        $dataset->delete();
        return response()->json(['message' => 'Dataset berhasil dihapus'], 200);
    }
}