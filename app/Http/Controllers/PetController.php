<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class PetController extends Controller
{
    protected PetService $petService;

    /**
     * Pet Controller constructor.
     *
     * @param PetService $petService
     */
    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    /**
     * Display list of pets.
     *
     * @return View
     */
    public function index(): View
    {
        $pets = $this->petService->getPets();

        return view('pets.index', compact('pets'));
    }

    /**
     * Show details of a pet.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $pet = $this->petService->getPet($id);

        return view('pets.show', compact('pet'));
    }

    /**
     * Display create new pet form.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Store new pet in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ]);

        try {
            $this->petService->createPet($request->all());

            return redirect()->route('pets.index')->with('success', 'Pet created successfully!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors(['error' => 'Failed to create pet. Please try again.']);
        }
    }

    /**
     * Display edit pet form.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $pet = $this->petService->getPet($id);

        return view('pets.edit', compact('pet'));
    }

    /**
     * Update pet in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,pending,sold',
        ]);

        try {
            $this->petService->updatePet($id, $request->all());

            return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors(['error' => 'Failed to update pet. Please try again.']);
        }
    }

    /**
     * Remove pet from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->petService->deletePet($id)) {
                return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
            } else {
                return redirect()->route('pets.index')->withErrors(['error' => 'Failed to delete pet.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->withErrors(['error' => 'Failed to delete pet.']);
        }
    }    
}
