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
        $contacts = Contact::with('category')->paginate(8);
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
        $contacts = $query->paginate(8)->withQueryString();
        return view('admin', compact('contacts', 'categories'));
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    public function export(Request $request)
    {
        $contacts = Contact::with('category')
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->CategorySearch($request->category)
            ->CreatedAtSearch($request->created_at)
            ->get();
        $filename ='contacts_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        $callback = function () use ($contacts){
            $stream = fopen('php://output', 'w');
            fputs($stream, "\xEF\xBB\xBF");
            fputcsv($stream, [
                'お名前',
                '性別',
                'メールアドレス',
                'お問い合わせの種類',
            ]);

            foreach ($contacts as $contact){
                $genderLabel = match ($contact->gender) {
                    1 => '男性',
                    2 => '女性',
                    3 => 'その他',
                    default => '未登録',
                };

                fputcsv($stream, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $genderLabel,
                    $contact->email,
                    $contact->category->content,
                ]);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }
}