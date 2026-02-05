<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterController extends Controller
{
    /**
     * Display subscriber list
     */
    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscribers = $query->latest()->paginate(50);

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::active()->count(),
            'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
        ];

        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    /**
     * Export subscribers as CSV
     */
    public function export(Request $request): StreamedResponse
    {
        $query = NewsletterSubscriber::query();

        if ($request->get('status') === 'active') {
            $query->active();
        }

        $subscribers = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($subscribers) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, ['Email', 'Durum', 'Abone Tarihi', 'İptal Tarihi']);

            // Data rows
            foreach ($subscribers as $subscriber) {
                fputcsv($handle, [
                    $subscriber->email,
                    $subscriber->is_active ? 'Aktif' : 'İptal',
                    $subscriber->subscribed_at?->format('Y-m-d H:i'),
                    $subscriber->unsubscribed_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Delete subscriber
     */
    public function destroy(NewsletterSubscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()->route('admin.newsletter.index')
            ->with('success', 'Abone başarıyla silindi.');
    }

    /**
     * Toggle subscriber status
     */
    public function toggleStatus(NewsletterSubscriber $subscriber): RedirectResponse
    {
        if ($subscriber->is_active) {
            $subscriber->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);
            $message = 'Abonelik iptal edildi.';
        } else {
            $subscriber->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
            $message = 'Abonelik aktif edildi.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Bulk delete subscribers
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:newsletter_subscribers,id',
        ]);

        NewsletterSubscriber::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.newsletter.index')
            ->with('success', count($request->ids) . ' abone silindi.');
    }
}
