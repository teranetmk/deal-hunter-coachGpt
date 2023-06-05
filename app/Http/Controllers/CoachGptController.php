<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Orhanerday\OpenAi\OpenAi;

class CoachGptController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Clients/CoachGpt/Gpt');
    }

    public function getAnswer(Request $request)
    {
        if (empty($request->prompt)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Question is required.',
            ]);
        }
        if ((auth()->user()->total_credits ?? 0) <= 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please top up your credits before you can ask questions.',
            ]);
        }
        $available_token = $this->getAvailableToken();

        $open_ai = new OpenAi(config('services.openai.key'));

        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant that writes code."
                ],
                [
                    "role" => "user",
                    "content" => $request->prompt,
                ],
            ],
            'temperature' => 1,
            'max_tokens' => $available_token,
        ]);

        $response = json_decode($complete , true);

        if (isset($response['choices'])) {

            $text = $response['choices'][0]['message']['content'];
            $tokens = $response['usage']['total_tokens'];
            $this->updateTokenUsed($tokens);

            return response()->json([
                'status' => 'success',
                'prompt_answer' => [
                    'prompt' => $request->prompt,
                    'response' => $text,
                ],
                'available_credit' => auth()->user()->total_credits ?? 0,
            ], 200);

        } else {

            if (isset($response['error']['message'])) {
                $message = $response['error']['message'];
            } else {
                $message = __('There is an issue with your openai account');
            }

            return response()->json([
                'status' => 'error',
                'message' => $message,
            ]);
        }

        $response = response()->json($response->json());

        if ($response->getStatusCode() == 200) {

            $response = $response->getData();

            //token used
            $response_total_tokens = $response->usage->total_tokens;
            $this->updateTokenUsed($response_total_tokens);

            $choices = $response->choices;

            return response()->json([
                'status' => 'success',
                'prompt_answer' => [
                    'prompt' => $request->prompt,
                    'response' => $choices[0]->text,
                ],
                'response_total_tokens' => $response_total_tokens,
                'available_credit' => auth()->user()->total_credits ?? 0,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ]);
        }
    }

    public function getAvailableToken(): int
    {
        $user = auth()->user();

        $available_token = (($user->total_credits ?? 0) - 1) * env('PER_CREDIT_TOKEN');

        if ($available_token > env('PER_REQUEST_MAX_TOKEN')) {
            $available_token = env('PER_REQUEST_MAX_TOKEN');
        } else if($available_token < 0)
        {
            $available_token = 0;
        } else{
            $available_token = $available_token - $user->token_used;
        }

        return $available_token;
    }

    public function updateTokenUsed($token_used)
    {
        $user = auth()->user();

        $tokens = $user->token_used + $token_used;

        if ($tokens >= env('PER_CREDIT_TOKEN')) {
            $credit_to_be_cut = floor($tokens / env('PER_CREDIT_TOKEN'));
            $user->total_credits = $user->total_credits - $credit_to_be_cut;
            $tokens = $tokens % env('PER_CREDIT_TOKEN');
        }

        $user->token_used = $tokens;
        $user->save();
    }
}
