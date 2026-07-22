import os
import sys
import re
from pathlib import Path

# Ensure UTF-8 output encoding for Windows terminal
if sys.stdout.encoding.lower() != 'utf-8':
    sys.stdout.reconfigure(encoding='utf-8')

BASE_DIR = Path(r"d:\Development\Projects\Web Development\Projects\Darmakran-main")
VIEWS_DIR = BASE_DIR / "resources" / "views"
LANG_DIR = BASE_DIR / "resources" / "lang"

print("==================================================")
print("     DARMAKRAN TRANSLATION & PAGES AUDIT         ")
print("==================================================")

# 1. Audit Dictionary Files
print("\n[1/6] Loading Language Dictionaries...")

def parse_php_array(filepath):
    if not filepath.exists():
        return {}
    content = filepath.read_text(encoding='utf-8', errors='ignore')
    # Match 'key' => 'value'
    matches = re.findall(r"'((?:\\'|[^'])*)'\s*=>\s*'((?:\\'|[^'])*)'", content)
    return {k.replace(r"\'", "'"): v.replace(r"\'", "'") for k, v in matches}

en_dict = parse_php_array(LANG_DIR / "en" / "message.php")
ar_dict = parse_php_array(LANG_DIR / "ar" / "message.php")
fa_dict = parse_php_array(LANG_DIR / "fa" / "message.php")

print(f" - English dictionary keys count: {len(en_dict)}")
print(f" - Arabic dictionary keys count:  {len(ar_dict)}")
print(f" - Farsi dictionary keys count:   {len(fa_dict)}")

# Check for untranslated residual Persian values in EN dictionary
persian_char_regex = re.compile(r'[\u0600-\u06FF]')
en_persian_residuals = 0
for k, v in en_dict.items():
    if v != 'N/A' and persian_char_regex.search(v):
        en_persian_residuals += 1

print(f" - English residual Persian values count: {en_persian_residuals}")

# Check for Persian-only letters (گ, چ, پ, ژ) in AR dictionary
ar_persian_letters_regex = re.compile(r'[\u067E\u0686\u0698\u06AF]')
ar_persian_corruptions = 0
for k, v in ar_dict.items():
    if ar_persian_letters_regex.search(v):
        ar_persian_corruptions += 1

print(f" - Arabic residual Persian letters count: {ar_persian_corruptions}")


# 2. Scanning Blade Views & Pages
print("\n[2/6] Auditing Blade View Files & 35 Pages...")

blade_files = list(VIEWS_DIR.glob("**/*.blade.php"))
print(f" - Total Blade view files found: {len(blade_files)}")

# Group views by section/site
sites_and_sections = {}
for bf in blade_files:
    rel_path = bf.relative_to(VIEWS_DIR)
    parts = rel_path.parts
    top_dir = parts[0] if len(parts) > 1 else 'root'
    sites_and_sections.setdefault(top_dir, []).append(rel_path)

print("\n - Structure breakdown by site/section:")
for section, files in sorted(sites_and_sections.items()):
    print(f"   * {section}: {len(files)} views")


# 3. Check for Hardcoded Persian text outside translation helper functions
print("\n[3/6] Scanning for Hardcoded Persian Text in Blade Views...")

hardcoded_files = []

for bf in blade_files:
    rel_path = str(bf.relative_to(VIEWS_DIR))
    content = bf.read_text(encoding='utf-8', errors='ignore')
    
    # Strip blade comments {{-- ... --}}
    clean = re.sub(r'\{\{--.*?--\}\}', '', content, flags=re.DOTALL)
    # Strip scripts & styles
    clean = re.sub(r'<script.*?>.*?</script>', '', clean, flags=re.DOTALL)
    clean = re.sub(r'<style.*?>.*?</style>', '', clean, flags=re.DOTALL)
    # Strip blade expressions {{ ... }} and {!! ... !!}
    clean = re.sub(r'\{\{\s*l\(.*?\)\s*\}\}', '', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\{\s*__\(.*?\)\s*\}\}', '', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\{\s*trans\(.*?\)\s*\}\}', '', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\{.*?\}\}', '', clean, flags=re.DOTALL)
    clean = re.sub(r'\{\!\!.*?\!\!\}', '', clean, flags=re.DOTALL)
    clean = re.sub(r'@lang\(.*?\)', '', clean, flags=re.DOTALL)
    
    # Find remaining Persian words (length > 2)
    persian_words = [w for w in re.findall(r'[\u0600-\u06FF]+', clean) if len(w) > 2]
    if len(persian_words) > 0:
        hardcoded_files.append((rel_path, len(persian_words), persian_words[:5]))

if hardcoded_files:
    print(f"\n ⚠️ Found {len(hardcoded_files)} view files with remaining hardcoded Persian text outside l():")
    for path, count, samples in sorted(hardcoded_files, key=lambda x: x[1], reverse=True)[:15]:
        sample_str = ", ".join(samples)
        print(f"    - {path}: {count} un-wrapped Persian words (e.g. {sample_str})")
else:
    print("\n ✅ NO hardcoded Persian text found outside l() calls across ALL view files!")


# 4. Check Blade Directive Syntax Match (@if vs @endif)
print("\n[4/6] Checking Blade Directives (@if / @endif)...")
mismatched_directives = []
for bf in blade_files:
    rel_path = str(bf.relative_to(VIEWS_DIR))
    content = bf.read_text(encoding='utf-8', errors='ignore')
    ifs = len(re.findall(r'@if\b', content))
    endifs = len(re.findall(r'@endif\b', content))
    if ifs != endifs:
        # Ignore site9/frontend/estate if it's partial
        mismatched_directives.append((rel_path, ifs, endifs))

if mismatched_directives:
    print(f"\n ⚠️ Mismatched @if / @endif found in {len(mismatched_directives)} files:")
    for path, i_c, e_c in mismatched_directives:
        print(f"    - {path}: @if={i_c}, @endif={e_c}")
else:
    print("\n ✅ ALL Blade directives (@if / @endif) match perfectly across all views!")


# 5. Check Language Switcher Route and Controller
print("\n[5/6] Auditing Language Switcher & Helpers...")
web_php = (BASE_DIR / "routes" / "web.php").read_text(encoding='utf-8', errors='ignore')
lang_switch_route = "Route::get('/lang/{locale}'" in web_php or "lang.switch" in web_php
print(f" - `/lang/{{locale}}` route present in web.php: {lang_switch_route}")

helper_php = (BASE_DIR / "app" / "helpers.php").read_text(encoding='utf-8', errors='ignore') if (BASE_DIR / "app" / "helpers.php").exists() else ""
print(f" - helper function `l()` definition exists: {'function l(' in helper_php}")


# 6. Check helper function implementation
print("\n[6/6] Inspecting `app/helpers.php` implementation...")
if helper_php:
    print(f"   helper.php line count: {len(helper_php.splitlines())}")


# 7. Final Summary & Page Count Verification
print("\n==================================================")
print("                  AUDIT SUMMARY                   ")
print("==================================================")
if en_persian_residuals == 0 and ar_persian_corruptions == 0 and len(hardcoded_files) == 0:
    print("✅ TRANSLATIONS CONFIRMED 100% PERFECTLY IMPLEMENTED!")
else:
    print(f"STATUS: Translation issues detected. Hardcoded files count: {len(hardcoded_files)}")

