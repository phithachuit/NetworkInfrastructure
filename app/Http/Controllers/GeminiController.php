<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

use App\Models\ChatBotModel;

class GeminiController extends Controller
{
    protected $geminiService;
    protected $apiKey;
    protected $baseUrl;

    // public function __construct(GeminiService $geminiService)
    // {
    //     $this->geminiService = $geminiService;
    // }

    public function __construct($userKeyword = null, $contextData = null)
    {
        // $this->geminiService = $geminiService;
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = env('GEMINI_API_URL');
    }

    public function getMessage(Request $request, ChatBotModel $ChatBotModel)
    {
        // lấy lịch sử tin nhắn theo id user
        return response()->json([
            'messages' => $ChatBotModel->getAllMessages()
            // 'messages' => $ChatBotModel->where('user_id', Auth::id())->get()->toArray()
        ]);
    }

    public function askGemini($userKeyword, $contextData = null)
    {
        // 1. Xây dựng Prompt (Câu lệnh cho AI)
        // Kỹ thuật này gọi là "Prompt Engineering" để định hướng AI đóng vai IT Support
        $systemInstruction = "Bạn là một trợ lý ảo IT chuyên nghiệp của trường học. " .
                             "Nhiệm vụ: Giải thích ngắn gọn, dễ hiểu về lỗi kỹ thuật đó và đưa ra giải pháp khắc phục thật chi tiết càng tốt. " .
                             "Cố gắng đưa ra các bước cụ thể để người dùng có thể tự khắc phục.";

        $prompt = "Người dùng đang gặp vấn đề với từ khóa: '{$userKeyword}'. \n";
        
        // Nếu bạn có dữ liệu lỗi từ Database (như bài trước), hãy nối vào đây để AI trả lời chính xác hơn
        if ($contextData) {
            $prompt .= "Dựa trên dữ liệu nội bộ sau đây để trả lời: " . $contextData;
        }

        // 2. Cấu trúc Request theo chuẩn Gemini API
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $systemInstruction . "\n\n" . $prompt]
                    ]
                ]
            ]
        ];

        // 3. Gửi Request
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", $payload);

            // dd($response->body());

            if ($response->successful()) {
                $data = $response->json();
                // Lấy nội dung text từ phản hồi phức tạp của Google
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi.';
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return "Hệ thống đang bận, vui lòng thử lại sau.";
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return "Lỗi kết nối đến máy chủ AI.";
        }
    }

    public function sendMessage(Request $request)
    {
        // Check quyền
        if (Auth::check()){
            if (Auth::user()->role !== 'admin') {
                return response()->json([
                    'reply' => 'Bạn không có quyền sử dụng chức năng này'
                ], 403);
            }
        }

        $keyword = $request->input('messageChat');
        // store user message in database
        $this->saveChatMessage('user', $keyword);

        // dd($keyword);

        // BƯỚC A: Tìm trong Database nội bộ trước (Ưu tiên dữ liệu chính xác của trường)
        // Ví dụ: tìm xem có lỗi nào khớp trong DB không để lấy làm "context"
        // $localData = ErrorDefinition::where('keyword', 'LIKE', "%{$keyword}%")->first();
        // Ensure variable is defined to avoid undefined variable access
        $localData = null;
        $context = null;
        if ($localData) {
            $context = "Tên lỗi: {$localData->error_name}. Cách sửa: {$localData->solution}";
        }
        // Fallback context (temporary placeholder)
        $context = $context ?? "Tên lỗi";

        // BƯỚC B: Gửi cho Gemini xử lý ngôn ngữ tự nhiên
        // Gemini sẽ dùng keyword + context (nếu có) để viết thành câu trả lời hay hơn
        $botReply = $this->askGemini($keyword, $context);

        // Try to convert Markdown to HTML if the helper exists; fallback to raw reply on error
        try {
            $htmlContent = Str::markdown($botReply);
        } catch (\Throwable $e) {
            Log::error('Markdown conversion failed: ' . $e->getMessage());
            $htmlContent = $botReply;
        }

        // Store bot reply in database
        if($botReply) {
            $this->saveChatMessage('bot', $htmlContent);
        }

        return response()->json([
            'reply' => $htmlContent
        ]);
    }

    public function saveChatMessage($sender, $data)
    {
        $chatBotModel = new ChatBotModel();
        $chatBotModel->saveMessage($sender, $data);
    }

    // Dự báo
    public function askDiagnose($ask) {
        // 1. Xây dựng Prompt (Câu lệnh cho AI)
        // Kỹ thuật này gọi là "Prompt Engineering" để định hướng AI đóng vai IT Support
        $systemInstruction = "Bạn là một chuyên gia phân tích, cảnh báo rủi ro tiềm ẩn. " .
                             "Nhiệm vụ: Giải thích thật ngắn gọn, tập trung trọng tâm. Đưa ra các rủi ro tiềm ẩn, khả năng xảy ra những rủi ro nào tiếp theo trong tương lai" .
                             "Cố gắng cảnh báo thật đúng trọng tâm.";

        $prompt = "Hệ thống đang gặp vấn đề gì? Đây là các dòng log từ hệ thống: '{$ask}'. \n";
    
        // 2. Cấu trúc Request theo chuẩn Gemini API
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $systemInstruction . "\n\n" . $prompt]
                    ]
                ]
            ]
        ];

        // 3. Gửi Request
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", $payload);

            if ($response->successful()) {
                $data = $response->json();
                // Lấy nội dung text từ phản hồi phức tạp của Google
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi.';
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return "Hệ thống đang bận, vui lòng thử lại sau.";
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return "Lỗi kết nối đến máy chủ AI.";
        }
    }

    public function sendDiagnose($data) {
        // return $data;

        // return response()->json([
        //     'reply' => 'alo'
        // ]);

        $botReply = $this->askDiagnose($data);

        // Try to convert Markdown to HTML if the helper exists; fallback to raw reply on error
        try {
            $htmlContent = Str::markdown($botReply);
        } catch (\Throwable $e) {
            Log::error('Markdown conversion failed: ' . $e->getMessage());
            $htmlContent = $botReply;
        }

        return response()->json([
            'reply' => $htmlContent
        ]);
    }

    public function mailDiagnose($ask){
        // 1. Xây dựng Prompt (Câu lệnh cho AI)
        // Kỹ thuật này gọi là "Prompt Engineering" để định hướng AI đóng vai IT Support
        $systemInstruction = "Nhiệm vụ của bạn: Giải thích lỗi đang xảy ra. Đưa ra cách giải quyết và hướng dẫn người dùng làm theo để khắc phục" .
                             "Cố gắng hướng dẫn đúng trọng tâm.";

        $prompt = "Hệ thống đang gặp vấn đề: '{$ask}'. \n";
    
        // 2. Cấu trúc Request theo chuẩn Gemini API
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $systemInstruction . "\n\n" . $prompt]
                    ]
                ]
            ]
        ];

        // 3. Gửi Request
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", $payload);

            if ($response->successful()) {
                $data = $response->json();
                // Lấy nội dung text từ phản hồi phức tạp của Google
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi.';
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return "Hệ thống đang bận, vui lòng thử lại sau.";
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return "Lỗi kết nối đến máy chủ AI.";
        }
    }

    public function sendMailDiagnose($data) {
        set_time_limit(0);
        $botReply = $this->mailDiagnose($data);

        // Try to convert Markdown to HTML if the helper exists; fallback to raw reply on error
        try {
            $htmlContent = Str::markdown($botReply);
        } catch (\Throwable $e) {
            Log::error('Markdown conversion failed: ' . $e->getMessage());
            $htmlContent = $botReply;
        }

        // return response()->json([
        //     'reply' => $htmlContent
        // ]);

        // return response()->json([
        //     'reply' => 'jajaja'
        // ]);

        return [
            'reply' => new HtmlString($htmlContent)
        ];
    }
}
