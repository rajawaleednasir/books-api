<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use  App\Helpers\ApiResponse;

class BookController extends Controller
{
    public function index(): JsonResponse {   
            return ApiResponse::success("Record fetched successfully", Book::latest()->paginate(15));
    }

    public function store(StoreBookRequest $request): JsonResponse {
        $book = Book::create($request->validated());
        return ApiResponse::success("Book created", $book);      
    }

    public function show(Book $book): JsonResponse {      
        return ApiResponse::success("Book fetched succefully", $book);   
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse {
        $book->update($request->validated());
        return ApiResponse::success("Book updated", $book);  
     
    }
    public function destroy(Book $book): JsonResponse {
            $book->delete();
           return ApiResponse::success("Book deleted", $book);      
    }
}
