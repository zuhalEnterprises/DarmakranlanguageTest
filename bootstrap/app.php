<?php
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ShareDataInFrontend;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ShareDataInFrontend::class);
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            try {

                /*$token = env('TELEGRAM_BOT_TOKEN');
                $chatId = env('TELEGRAM_CHAT_ID');
                $message = "*Laravel Error Log*\n\n" . $e->getMessage();
                dd("https://api.telegram.org/bot{$token}/sendMessage");
                Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                ]);*/

                // ذخیره اطلاعات خطا در جدول errorlog
                DB::table('errorlog')->insert([
                    'message' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                    'level' => method_exists($e, 'getStatusCode') && $e->getStatusCode() < 500 ? 'warning' : 'error',
                    'url' => request()->fullUrl(),
                    'route_name'   => $request->route() ? $request->route()->getName() : null, // نام Route لاراول
                    'method'       => $request->method(), // متد درخواست (GET, POST, ...)
                    'request_data' => json_encode($request->all()), // داده‌های ورودی درخواست
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'ip' => getIp(),
                    'fullurl' => $_SERVER["REQUEST_URI"],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


            } catch (\Exception $e) {
                // جلوگیری از خطای بیشتر
            }
        });
    })->create();
