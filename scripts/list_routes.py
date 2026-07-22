import re
from pathlib import Path

web_php = Path(r"d:\Development\Projects\Web Development\Projects\Darmakran-main\routes\web.php").read_text(encoding='utf-8')

# Find all Route::get calls
routes = re.findall(r"Route::get\s*\(\s*['\"]([^'\"]+)['\"]", web_php)
print(f"Total GET routes in web.php: {len(routes)}")
for r in routes:
    print(" - ", r)
