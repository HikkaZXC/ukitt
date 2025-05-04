<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OrganController extends Controller
{
    /**
     * Отображает список всех организаций в административной панели
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('organ.index', compact('organizations'));
    }
    
    /**
     * Отображает форму для создания новой организации
     */
    public function create()
    {
        return view('organ.create');
    }
    
    /**
     * Сохраняет новую организацию в базе данных
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Поле "Название" обязательно для заполнения',
            'name.string' => 'Поле "Название" должно быть строкой',
            'name.max' => 'Длина названия не должна превышать 255 символов',
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения',
            'address.required' => 'Поле "Адрес" обязательно для заполнения',
            'logo.required' => 'Логотип обязателен для загрузки',
            'logo.image' => 'Файл должен быть изображением',
            'logo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg, gif',
            'logo.max' => 'Размер изображения не должен превышать 2MB',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
        
        // Создание организации с временным значением logo
        $organization = new Organization();
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->address = $request->address;
        $organization->user_id = Auth::id();
        $organization->logo = 'temp'; // Временное значение для logo
        $organization->save();
        
        // Создаем директорию для логотипов организации, если не существует
        $logoPath = 'img/organizations/' . $organization->id;
        $fullPath = public_path($logoPath);
        if (!file_exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        // Сохранение изображения
        $logoName = time() . '_' . Str::slug($request->name) . '.' . $request->logo->extension();
        $request->logo->move($fullPath, $logoName);
        
        // Обновляем запись с правильным путем к логотипу
        $organization->logo = $logoPath . '/' . $logoName;
        $organization->save();
        
        return redirect()->route('organ.index')->with('success', 'Организация успешно создана!');
    }
    
    /**
     * Отображает конкретную организацию
     */
    public function show(Organization $organ)
    {
        return view('organ.show', compact('organ'));
    }
    
    /**
     * Отображает форму для редактирования существующей организации
     */
    public function edit(Organization $organ)
    {
        return view('organ.edit', compact('organ'));
    }
    
    /**
     * Обновляет существующую организацию в базе данных
     */
    public function update(Request $request, Organization $organ)
    {
        $messages = [
            'name.required' => 'Поле "Название" обязательно для заполнения',
            'name.string' => 'Поле "Название" должно быть строкой',
            'name.max' => 'Длина названия не должна превышать 255 символов',
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения',
            'address.required' => 'Поле "Адрес" обязательно для заполнения',
            'logo.image' => 'Файл должен быть изображением',
            'logo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg, gif',
            'logo.max' => 'Размер изображения не должен превышать 2MB',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
        
        $organ->name = $request->name;
        $organ->email = $request->email;
        $organ->phone = $request->phone;
        $organ->address = $request->address;
        
        // Если загружен новый логотип
        if ($request->hasFile('logo')) {
            // Проверяем и создаем директорию для логотипов организации, если не существует
            $logoPath = 'img/organizations/' . $organ->id;
            $fullPath = public_path($logoPath);
            if (!file_exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }
            
            // Удаляем старый логотип, если он существует
            if ($organ->logo && file_exists(public_path($organ->logo))) {
                unlink(public_path($organ->logo));
            }
            
            // Сохраняем новый логотип
            $logoName = time() . '_' . Str::slug($request->name) . '.' . $request->logo->extension();
            $request->logo->move($fullPath, $logoName);
            $organ->logo = $logoPath . '/' . $logoName;
        }
        
        $organ->save();
        
        return redirect()->route('organ.index')->with('success', 'Организация успешно обновлена!');
    }
    
    /**
     * Удаляет организацию из базы данных
     */
    public function destroy(Organization $organ)
    {
        // Удаляем директорию с логотипом организации
        $logoPath = public_path('img/organizations/' . $organ->id);
        if (file_exists($logoPath)) {
            File::deleteDirectory($logoPath);
        }
        
        $organ->delete();
        
        return redirect()->route('organ.index')->with('success', 'Организация успешно удалена!');
    }
}
