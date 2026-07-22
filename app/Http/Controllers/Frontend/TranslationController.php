<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\GoogleTranslateService;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class TranslationController extends Controller
{
    protected $translator;

    public function __construct(GoogleTranslateService $translator)
    {
        $this->translator = $translator;
    }

    public function translate(Request $request)
    {
        $source = $request->input('source', 'en');
        $target = $request->input('target', 'fa');
        $text = $request->input('text', 'Hello, world!');

        try {
            $translatedText = $this->translator->translate($source, $target, $text);

            return response()->json([
                'translated' => $translatedText ?? $text,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'translated' => $text,
            ]);
        }
    }
}