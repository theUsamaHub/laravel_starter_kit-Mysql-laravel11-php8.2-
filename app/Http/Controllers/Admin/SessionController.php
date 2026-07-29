<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function index(): View
    {
        $sessions = DB::table('sessions')
            ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
            ->select('sessions.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('sessions.last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                $session->last_activity_human = now()->diffForHumans(
                    now()->setTimestamp($session->last_activity)
                );
                return $session;
            });

        return view('admin.sessions.index', compact('sessions'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $session = DB::table('sessions')->where('id', $id)->first();

        if (!$session) {
            return back()->with('error', 'Session not found.');
        }

        if ($session->id === session()->getId()) {
            return back()->with('error', 'Cannot revoke your own session.');
        }

        DB::table('sessions')->where('id', $id)->delete();

        return back()->with('success', 'Session revoked successfully.');
    }
}
