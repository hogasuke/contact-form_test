<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->get();
        $categories = Category::all();
        return view('index', compact('contacts', 'categories'));
    }

    public function confirm(Request $request)
    {
        $contact = $request->only([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'detail'
        ]);
        $category = Category::find($contact['category_id']);
        return view('confirm', compact('contact', 'category'));
    }

    public function back(Request $request)
    {
        return redirect('/')->withInput();
    }

    public function thanks(Request $request)
    {
        $contact = $request->only([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'detail'
        ]);
        switch($contact['gender']) {
            case '男性':
                $contact['gender'] = 1;
                break;
            case '女性':
                $contact['gender'] = 2;
                break;
            case 'その他':
                $contact['gender'] = 3;
                break;
        }
        $contact['tel'] = "{$contact['tel1']}-{$contact['tel2']}-{$contact['tel3']}";
        unset($contact['tel1'], $contact['tel2'], $contact['tel3']);
        Contact::create($contact);
        return view('thanks');
    }

    public function home()
    {
        return redirect('/');
    }
}