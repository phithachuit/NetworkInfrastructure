<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = env('GEMINI_API_URL');
    }

    public function askGemini($userKeyword, $contextData = null)
    {
        // 1. Xây dựng Prompt (Câu lệnh cho AI)
        // Kỹ thuật này gọi là "Prompt Engineering" để định hướng AI đóng vai IT Support
        $systemInstruction = "Bạn là một trợ lý ảo IT chuyên nghiệp của trường học. " .
                             "Nhiệm vụ: Giải thích ngắn gọn lỗi kỹ thuật và đưa ra giải pháp khắc phục. " .
                             "Nếu không biết, hãy nói cần liên hệ bộ phận IT.";

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
}