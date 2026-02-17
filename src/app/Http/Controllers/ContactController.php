<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $categories = Category::all();
        return view('index', compact('contacts', 'categories'));
    }

    public function confirm(ContactRequest $request)
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
        $gender = $request->only(['gender']);
        switch($gender['gender']) {
            case 1:
                $gender['gender'] = '男性';
                break;
            case 2:
                $gender['gender'] = '女性';
                break;
            case 3:
                $gender['gender'] = 'その他';
                break;
        }
        return view('confirm', compact('contact', 'category', 'gender'));
    }

    public function back(ContactRequest $request)
    {
        return redirect('/')->withInput();
    }

    public function thanks(ContactRequest $request)
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
        $contact['tel'] = "{$contact['tel1']}{$contact['tel2']}{$contact['tel3']}";
        unset($contact['tel1'], $contact['tel2'], $contact['tel3']);
        Contact::create($contact);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category)
            ->CreatedAtSearch($request->created_at);
        $categories = Category::all();
        $contacts = $query->paginate(7)->withQueryString();
        return view('admin', compact('contacts', 'categories'));
    }
}