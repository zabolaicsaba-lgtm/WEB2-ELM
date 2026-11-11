<?php
namespace App\Http\Controllers;
use App\Models\Person;
use Illuminate\Http\Request;
class PersonController extends Controller
{
    public function index()
    {
        $people = Person::all();
        return view('persons.index', compact('people'));
    }
    public function create()
    {
        return view('persons.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'height' => 'required|numeric|min:0',
        ]);
        try { 
            Person::create($validated); 
            return redirect() ->route('persons.index') ->with('success', 'Person successfully added!'); 
        } 
        catch (\Exception $e) { 
            return redirect() ->back() ->withInput() ->with('failed', 'Failed to add person!'); 
        }
    }
    public function edit(Person $person)
    {
        return view('persons.edit', compact('person'));
    }
    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'height' => 'required|numeric|min:0',
        ]);
        try { 
            $person->update($validated);
            return redirect() ->route('persons.index') ->with('success', 'Data successfully updated.'); 
        } 
        catch (\Exception $e) { 
            return redirect() ->back() ->withInput() ->with('failed', 'Data was not updated.'); 
        }
    }
    public function destroy(Person $person)
    {
        try { 
            $person->delete(); 
            return redirect() ->route('persons.index') ->with('success', 'Person successfully deleted!'); 
        } 
        catch (\Exception $e) { 
            return redirect() ->back() ->with('failed', 'Person was not deleted!'); 
        }
    }
}