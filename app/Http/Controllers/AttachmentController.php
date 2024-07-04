<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function index()
    {
        return Attachment::all();
    }

    public function show($id)
    {
        return Attachment::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_path' => 'required|string',
            'ticket_id' => 'nullable|exists:tickets,id',
            'comment_id' => 'nullable|exists:comments,id',
            'priority' => 'required|in:low,medium,high',
        ]);

        return Attachment::create($validated);
    }

    public function update(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);

        $validated = $request->validate([
            'file_path' => 'sometimes|required|string',
            'ticket_id' => 'nullable|exists:tickets,id',
            'comment_id' => 'nullable|exists:comments,id',
            'priority' => 'sometimes|required|in:low,medium,high',
        ]);

        $attachment->update($validated);

        return $attachment;
    }

    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->delete();

        return response()->noContent();
    }
}
