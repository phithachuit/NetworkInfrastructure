<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    public function scanMessage(Request $request)
    {
        return view('search');
    }

    public function sendMessage(Request $request)
    {
        $keyword = $request->input('message');

        // BƯỚC A: Tìm trong Database nội bộ trước (Ưu tiên dữ liệu chính xác của trường)
        // Ví dụ: tìm xem có lỗi nào khớp trong DB không để lấy làm "context"
        // $localData = ErrorDefinition::where('keyword', 'LIKE', "%{$keyword}%")->first();
        
        // $context = null;
        // if ($localData) {
        //     $context = "Tên lỗi: {$localData->error_name}. Cách sửa: {$localData->solution}";
        // }
        $context = "Tên lỗi";

        // BƯỚC B: Gửi cho Gemini xử lý ngôn ngữ tự nhiên
        // Gemini sẽ dùng keyword + context (nếu có) để viết thành câu trả lời hay hơn
        $botReply = $this->askGemini($keyword, $context);

        // Chuyển đổi định dạng Markdown sang HTML để hiển thị đẹp hơn
        $htmlContent = Str::markdown($botReply);

        echo $htmlContent;
        exit;

        return response()->json([
            'reply' => $botReply
        ]);
    }
}
