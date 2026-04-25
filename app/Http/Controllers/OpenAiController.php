<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OpenAiController extends Controller
{

    public $baseUrl = 'https://api.openai.com/v1/';

    public function submit(Request $request)
    {
        if(!showAIWriter()) {
            return response()->json(['error' => true, 'message' => __('general.ai_writer_disabled')], Response::HTTP_BAD_REQUEST);
        }

        $promptType = $request->input('promptType');
        if(empty(setting('_ai_writer_settings.' . $promptType . '_prompt'))) {
            return response()->json(['error' => true, 'message' => __('general.ai_writer_prompt_missing')], Response::HTTP_BAD_REQUEST);
        }

        if(empty(setting('_api.openai_api_key'))) {
            return response()->json(['error' => true, 'message' => __('general.openai_api_key_missing')], Response::HTTP_BAD_REQUEST);
        }

        $validator  = Validator::make($request->all(), [
            'aiInput' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }

        $aiResponse = $this->makeAiRequest($this->replacePromptVariables(setting('_ai_writer_settings.' . $promptType . '_prompt'), ['topic' => $request->input('aiInput')]));
 
        if ($aiResponse['success']) {
            return response()->json(['data' => ['response' => $aiResponse['response']]], Response::HTTP_OK);
        } else
            return response()->json(['error' => true, 'message' => $aiResponse['message']], Response::HTTP_BAD_REQUEST);
    }

     /**
     * Make API Call to openAi
     * @param string $prompt
     * @param integer $maxTokens
     * @param string $model
     */
     protected function makeAiRequest(string $prompt, string $model = 'gpt-4o-mini', $formatResponse = true): array {
        try {
 
            $params = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . setting('_api.openai_api_key'),
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . 'chat/completions', $params);
        
            if ($response->successful()) {
                $aiResponseAll = $response->json();
                $aiResponse = $aiResponseAll['choices'][0]['message']['content'];
                return [
                    'success' => true,
                    'response' => (!$formatResponse ? Str::of(preg_replace('/\s\s+/', ' ', str_replace('"', '', $aiResponse)))->toString():  Str::of(preg_replace('/\s\s+/', ' ', str_replace('"', '', $aiResponse)))->trim()->toString())
                ];
            } else {
                return ['success' => false, 'message' => $response->json()['error']['message'] ?? __('general.something_went_wrong')];
            }
            
        } catch (Exception $ex) {
            return ['success' => false, 'message' => $ex->getMessage()];
        }
    }

    protected function replacePromptVariables($prompt, $variables) {
        foreach($variables as $key => $value) {
            $prompt = str_replace('{' . $key . '}', $value, $prompt);
        }
        return $prompt;
    }
}
