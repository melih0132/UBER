<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entretien;
use App\Models\Coursier;
use Carbon\Carbon;

class EntretienController extends Controller
{
    public function index()
    {
        $this->reinitialiserEntretiensAnnules();

        $entretiens = Entretien::where('status', 'En attente')->get();

        return view('entretiens.index', compact('entretiens'));
    }

    public function listePlannifies()
    {
        $entretiens = Entretien::where('status', 'Planifié')->get();

        return view('entretiens.index', compact('entretiens'));
    }

    public function listeTermines()
    {
        $entretiens = Entretien::where('status', 'Terminée')
            ->whereNull('resultat')
            ->get();

        return view('entretiens.index', compact('entretiens'));
    }

    public function showPlanifierForm($id = null)
    {
        $coursiers = Coursier::all();
        $entretien = $id ? Entretien::findOrFail($id) : null;

        return view('entretiens.planifier', compact('coursiers', 'entretien'));
    }

    public function planifier(Request $request, $id = null)
    {
        $statuses = ['En attente', 'Planifié', 'Terminée', 'Annulée'];

        $validated = $request->validate([
            'idcoursier' => 'required|exists:coursier,idcoursier',
            'dateentretien' => 'required|date|after_or_equal:today',
            'status' => 'required|in:' . implode(',', $statuses),
        ]);

        try {
            $entretien = $id ? Entretien::findOrFail($id) : new Entretien();
            $entretien->idcoursier = $validated['idcoursier'];
            $entretien->dateentretien = Carbon::parse($validated['dateentretien']);
            $entretien->status = $validated['status'];
            $entretien->save();

            $message = $id
                ? 'Entretien mis à jour avec succès.'
                : 'Entretien planifié avec succès.';

            return redirect()->route('entretiens.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('entretiens.index')
                ->with('error', 'Une erreur est survenue lors de la planification de l\'entretien.');
        }
    }

    public function reinitialiserEntretiensAnnules()
    {
        Entretien::where('status', 'Annulée')->update([
            'status' => 'En attente',
            'dateentretien' => null
        ]);
    }

    public function enregistrerResultat(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Terminée,Annulée',
        ]);

        try {
            $entretien = Entretien::findOrFail($id);

            if ($entretien->status !== 'Planifié') {
                return redirect()->route('entretiens.index')
                    ->with('error', 'Seuls les entretiens planifiés peuvent être terminés ou annulés.');
            }

            $entretien->status = $validated['status'];
            $entretien->save();

            return redirect()->route('entretiens.index')
                ->with('success', 'Résultat de l\'entretien enregistré avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('entretiens.index')
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du résultat.');
        }
    }

    public function validerCoursier($id)
    {
        try {
            $entretien = Entretien::findOrFail($id);

            if ($entretien->status !== 'Terminée') {
                return redirect()->route('entretiens.index')
                    ->with('error', 'Seuls les entretiens terminés peuvent être validés.');
            }

            $coursier = Coursier::findOrFail($entretien->idcoursier);

            $coursier->datedebutactivite = Carbon::now();
            $coursier->save();

            $entretien->resultat = 'Retenu';
            $entretien->rdvlogistiquedate = Carbon::now()->addDays(3);
            $entretien->rdvlogistiquelieu = 'Centre Logistique Uber';
            $entretien->save();

            return redirect()->route('entretiens.index')
                ->with('success', 'Coursier validé avec succès. Un rendez-vous logistique a été programmé.');
        } catch (\Exception $e) {
            return redirect()->route('entretiens.index')
                ->with('error', 'Une erreur est survenue lors de la validation du coursier.');
        }
    }

    public function refuserCoursier($id)
    {
        try {
            $entretien = Entretien::findOrFail($id);

            if ($entretien->status !== 'Terminée') {
                return redirect()->route('entretiens.index')
                    ->with('error', 'Seuls les entretiens terminés peuvent être refusés.');
            }

            $coursier = Coursier::findOrFail($entretien->idcoursier);

            $coursier->delete();
            $entretien->resultat = 'Rejeté';
            $entretien->save();

            return redirect()->route('entretiens.index')
                ->with('success', 'Coursier refusé avec succès. Les données associées ont été supprimées.');
        } catch (\Exception $e) {
            return redirect()->route('entretiens.index')
                ->with('error', 'Une erreur est survenue lors du refus du coursier.');
        }
    }

    public function supprimer($id)
    {
        try {
            $entretien = Entretien::findOrFail($id);
            $entretien->delete();

            return redirect()->route('entretiens.index')
                ->with('success', 'Entretien supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('entretiens.index')
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'entretien.');
        }
    }
}