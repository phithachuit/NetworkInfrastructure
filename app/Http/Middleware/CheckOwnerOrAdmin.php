<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Lấy User đang đăng nhập
        $currentUser = Auth::user();

        // 2. Nếu chưa đăng nhập -> đuổi ra (hoặc để middleware 'auth' lo)
        if (!$currentUser) {
            return redirect()->route('login');
        }

        // 3. Ưu tiên: Nếu là ADMIN -> Cho qua luôn, không cần check gì nữa
        if ($currentUser->role === 'admin') {
            return $next($request);
        }

        // 4. Lấy ID từ trên URL xuống để so sánh
        // Lưu ý: 'user_id' phải trùng với tên tham số bạn đặt trong Route
        // Ví dụ route: /user/edit/{user_id} -> thì ở đây gọi 'user_id'
        $routeId = $request->route('user_id'); 

        // 5. So sánh: ID đang login có trùng với ID trên URL không?
        // Dùng == để so sánh lỏng (số với chuỗi đều được)
        if ($currentUser->id == $routeId) {
            return $next($request);
        }

        // 6. Nếu xuống tới đây nghĩa là: Không phải Admin, cũng không phải Chính chủ
        return redirect()->back()->withErrors('Bạn không có quyền truy cập dữ liệu này.');
    }
}
