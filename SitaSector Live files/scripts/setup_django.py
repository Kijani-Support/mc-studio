"""Create SQLite tables for Django sectors (healthtech, agritech, energy)."""
import os
import subprocess
import sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
PROJECTS = [
    ("healthtech", "healthtech.settings"),
    ("agritech", "agritech.settings"),
    ("energy", "energy.settings"),
]


def setup_project(folder: str, settings_module: str) -> None:
    sector_path = os.path.join(ROOT, folder)
    code = f"""
import os, sys, django
sys.path.insert(0, r'{ROOT}')
sys.path.insert(0, r'{sector_path}')
os.environ['DJANGO_SETTINGS_MODULE'] = '{settings_module}'
django.setup()
from django.core.management import call_command
call_command('makemigrations', 'models', interactive=False, verbosity=0)
call_command('migrate', interactive=False, verbosity=0)
print('[setup] {folder} database ready')
"""
    subprocess.run([sys.executable, "-c", code], cwd=ROOT, check=True)


if __name__ == "__main__":
    for folder, settings in PROJECTS:
        setup_project(folder, settings)
