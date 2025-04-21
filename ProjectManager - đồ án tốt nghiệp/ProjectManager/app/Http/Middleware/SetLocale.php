<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
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
    // q-read: Lấy ngôn ngữ từ session, nếu không có thì sử dụng ngôn ngữ mặc định
    $locale = session('locale', config('app.locale')); // 'locale' là ngôn ngữ trong session, nếu không có sẽ dùng mặc định

    // Thiết lập ngôn ngữ của ứng dụng
    App::setLocale($locale);

    return $next($request);
  }
}
