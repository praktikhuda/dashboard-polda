<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index () 
    {
        return view('pages.table');
    }

    public function tambah(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'data' => 'required|json',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }

        $data = $req->only(['judul', 'deskripsi']);

        $dataDecoded = json_decode($req->data, true);

        if (is_array($dataDecoded)) {
            $data['data'] = json_encode($dataDecoded);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
            ]);
        }   

        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('uploads', 'public');
            $data['image'] = $imagePath;
        }

        $tambah = DB::table('table')->insert($data);

        if ($tambah) {
            return response()->json([
                'status' => 'berhasil',
                'toast' => 'Berhasil menambah table',
                'resets' => 'all',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'toast' => 'Gagal menambah table',
                'resets' => 'all',
            ]);
        }
    }

    public function lihat ()
    {
        $table = DB::table('table')->orderBy('id', 'desc')->get();
        return response()->json($table);
    }

    public function cari(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->id;
        $table = DB::table('table')->where('id', $data)->get();
        return response()->json($table);
    }

    public function edit(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->id;
        $table = DB::table('table')->where('id', $data)->get();
        return response()->json($table);
    }

    public function lihatTable (Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->id;
        if ($data) {
            return response()->json([
                'status'    => 'success',
                'toast'     => 'Login berhasil',
                'resets'    => 'all',
                'redirect'  => route('lihatTable-v2')
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
                'toast'     => 'Gagal Cari Data',
                'redirect'  => route('lihatTable-v2')
            ]);
        }
    }

    // pages.lihatTable
    public function lihatTable_v2 ()  
    {
        return view('pages.lihatTable');
    }
    public function tambahTable__(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->id;
        $table = DB::table('table')->where('id', $data)->get();
        if ($table) {
            return response()->json([
                'status'    => 'success',
                'toast'     => 'Load berhasil',
                'data'    => $table,
                'redirect'  => route('modal-v3')
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
                'toast'     => 'Gagal Cari Data'
            ]);
        }
    }
    public function addTable__(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'dataJson'  => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->dataJson;

        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }

        $tambah = DB::table('isi_table')->insert($data);
        if ($tambah) {
            return response()->json([
                'status'    => 'berhasil',
                'toast'     => 'Berhasil menambah',
                'resets'    => 'all'
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
                'toast'     => 'Username atau password salah!',
                'resets'    => 'all'
            ]);
        }
    }

    public function cariTable__(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $data = $req->id;
        $table = DB::table('isi_table')->where('id_table', $data)->get();
        return response()->json($table);
    }
}
