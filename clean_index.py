#!/usr/bin/env python3
import re

# Read the file
with open('index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Find the position of </footer>
footer_end = content.find('</footer>')
if footer_end == -1:
    print("Error: </footer> not found")
    exit(1)

# Find the position after </footer> and before the first <script
footer_end_pos = content.find('>', footer_end) + 1

# Find the first <script after footer
script_start = content.find('<script', footer_end_pos)
if script_start == -1:
    print("Error: <script not found after footer")
    exit(1)

# Find <!-- Scripts --> before the script
scripts_comment_start = content.rfind('<!-- Scripts -->', footer_end_pos, script_start)

# Extract parts
before_footer = content[:footer_end_pos]
after_scripts = content[scripts_comment_start:]

# Combine with the include
new_content = before_footer + "\n\n    <?php include 'includes/simulators-modal.php'; ?>\n\n    " + after_scripts

# Write the cleaned file
with open('index.php', 'w', encoding='utf-8') as f:
    f.write(new_content)

print("File cleaned successfully!")

