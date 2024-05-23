<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(FileRequest $request)
    {
        
       return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(FileRequest $request, File $file)
    {
        return $this->service->update($request, $file);
    }

    public function destroy(File $file)
    {
        return $this->service->destroy($file);
    }
}
