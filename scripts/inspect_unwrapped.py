import sys
import re
from pathlib import Path

if sys.stdout.encoding.lower() != 'utf-8':
    sys.stdout.reconfigure(encoding='utf-8')

BASE_DIR = Path(r"d:\Development\Projects\Web Development\Projects\Darmakran-main")
VIEWS_DIR = BASE_DIR / "resources" / "views"

test_files = [
    "frontend/estate/advanced_search_fields_vmobile2.blade.php",
    "site7/frontend/intro/index.blade.php",
    "frontend/blog/show.blade.php",
]

for tf in test_files:
    p = VIEWS_DIR / tf
    if not p.exists():
        continue
    content = p.read_text(encoding='utf-8', errors='ignore')
    print(f"\n==================================================")
    print(f"File: {tf}")
    print(f"==================================================")
    
    clean = re.sub(r'\{\{--.*?--\}\}', '', content, flags=re.DOTALL)
    clean = re.sub(r'<script.*?>.*?</script>', '', clean, flags=re.DOTALL)
    clean = re.sub(r'<style.*?>.*?</style>', '', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\{\s*l\(.*?\)\s*\}\}', '[L_CALL]', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\{\s*__\(.*?\)\s*\}\}', '[L_CALL]', clean, flags=re.DOTALL)
    
    lines = clean.splitlines()
    persian_lines = []
    for i, line in enumerate(lines, 1):
        if re.search(r'[\u0600-\u06FF]', line):
            persian_lines.append((i, line.strip()))
            
    print(f"Total lines with Persian chars outside l(): {len(persian_lines)}")
    for lno, text in persian_lines[:15]:
        print(f"  Line {lno}: {text}")
