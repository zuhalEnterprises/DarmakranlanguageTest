import re
from pathlib import Path

p = Path(__file__).resolve().parent.parent / "resources/lang/ar/message.php"
content = p.read_text(encoding="utf-8")
entries = re.findall(r"'((?:\\'|[^'])*)'\s*=>\s*'((?:\\'|[^'])*)'", content)
english_like = 0
for k, v in entries:
    if re.search(r"[A-Za-z]{3,}", v) and not re.search(r"[\u0600-\u06FF]", v):
        english_like += 1
print(f"Total: {len(entries)}, English-like values: {english_like}")
