<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    //HIển thị tất cả các bài blog (theo trang , và số lượng blog tùy chọn) (dùng trong trang admin hoặc danh sách trang home)
    public function index(Request $request)
    {
        $blog = [];

        $blog["count"] = Blog::all()->count();
        $blog["blogs"] =  Blog::take($request->count)->skip(($request->page - 1) * $request->count)->get();

        foreach ($blog["blogs"] as $item) {
            $item["category"] = Blog::find($item->id)->category;
            foreach ($item["category"] as $i) {
                unset($i["created_at"]);
                unset($i["updated_at"]);
                unset($i["pivot"]);
            }
            unset($item["content"]);
        }

        return response()->json($blog, 200)->header('Content-Type', 'application/json');
    }

    //Hiển thị chi tiết một blog
    public function show($path)
    {
        $blog = Blog::where("path", $path)->first();
        $blog["category"] = Blog::find($blog->id)->category;
        foreach ($blog["category"] as $i) {
            unset($i["created_at"]);
            unset($i["updated_at"]);
            unset($i["pivot"]);
        }

        return response()->json($blog, 200)->header('Content-Type', 'application/json');
    }

    //HIển thị danh sách blog theo từng thể loại
    public function category($path)
    {
        $blog = Category::where("path", $path)->first()->blogs;

        foreach ($blog as $item) {
            unset($item["pivot"]);
        }

        return response()->json($blog, 200)->header('Content-Type', 'application/json');
    }

    //Tạo blog mới
    public function create(Request $request)
    {
        $blog = new Blog();

        $blog->title  = $request->title;
        $blog->text = $request->text;
        $blog->author = $request->author;
        $blog->image = $request->image;
        $blog->path = $request->path;
        $blog->save();

        foreach ($request->category as $item) {
            $blogCategory = new BlogCategory();
            $blogCategory->blog_id  = $blog->id;
            $blogCategory->category_id = $item;
            $blogCategory->save();
        }

        return response()->json($blog, 200)->header('Content-Type', 'application/json');
    }

    //Xóa blog
    public function delete($id)
    {
        Blog::destroy($id);

        BlogCategory::where("blog_id", $id)->delete();
    }

    //Sửa nội dung blog
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $blog->title  = $request->title;
        $blog->text = $request->text;
        $blog->author = $request->author;
        $blog->image = $request->image;
        $blog->path = $request->path;
        $blog->save();

        BlogCategory::where("blog_id", $id)->delete();
        foreach ($request->category as $item) {
            $blogCategory = new BlogCategory();
            $blogCategory->blog_id  = $id;
            $blogCategory->category_id = $item;
            $blogCategory->save();
        }

        return response()->json($blog, 200)->header('Content-Type', 'application/json');
    }
}
