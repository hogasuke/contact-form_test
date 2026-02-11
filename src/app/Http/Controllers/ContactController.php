<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
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
        $gender = $request->only(['gender']);
        $category = Category::find($contact['category_id']);
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

    public function admin()
    {
        $contacts = Contact::Paginate(7);
        return view('admin', ['contacts' => $contacts]);
    }

    public function search(Request $request)
    {
        $contacts = Contact::query();
        $category_id = $request->input('category_id');
    }
}