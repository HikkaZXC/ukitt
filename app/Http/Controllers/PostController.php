<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        // Проверяем аутентификацию и права администратора в маршрутах
        // в web.php вместо здесь, поскольку у нас отдельный middleware для ролей
    }
    
    /**
     * Отображает список всех новостей в административной панели
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('post.index', compact('posts'));
    }
    
    /**
     * Отображает форму для создания новой новости
     */
    public function create()
    {
        return view('post.create');
    }
    
    /**
     * Сохраняет новую новость в базе данных
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Создание новости с временным значением image
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();
        $post->image = 'temp'; // Временное значение для image
        $post->save();
        
        // Создаем директорию для изображений поста, если не существует
        $imagePath = 'img/' . $post->id;
        $fullPath = public_path($imagePath);
        if (!file_exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        // Сохранение изображения
        $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
        $request->image->move($fullPath, $imageName);
        
        // Обновляем запись с правильным путем к изображению
        $post->image = $imagePath . '/' . $imageName;
        $post->save();
        
        return redirect()->route('post.index')->with('success', 'Новость успешно создана!');
    }
    
    /**
     * Отображает конкретную новость
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }
    
    /**
     * Отображает форму для редактирования существующей новости
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }
    
    /**
     * Обновляет существующую новость в базе данных
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $post->title = $request->title;
        $post->content = $request->content;
        
        // Если загружено новое изображение
        if ($request->hasFile('image')) {
            // Проверяем и создаем директорию для изображений поста, если не существует
            $imagePath = 'img/' . $post->id;
            $fullPath = public_path($imagePath);
            if (!file_exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }
            
            // Удаляем старое изображение, если оно существует
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            
            // Сохраняем новое изображение
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->move($fullPath, $imageName);
            $post->image = $imagePath . '/' . $imageName;
        }
        
        $post->save();
        
        return redirect()->route('post.index')->with('success', 'Новость успешно обновлена!');
    }
    
    /**
     * Удаляет новость из базы данных
     */
    public function destroy(Post $post)
    {
        // Удаляем директорию с изображениями поста
        $imagePath = public_path('img/' . $post->id);
        if (file_exists($imagePath)) {
            File::deleteDirectory($imagePath);
        }
        
        $post->delete();
        
        return redirect()->route('post.index')->with('success', 'Новость успешно удалена!');
    }
}
