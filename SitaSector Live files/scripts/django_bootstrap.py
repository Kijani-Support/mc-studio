"""Call from sector tests after setting DJANGO_SETTINGS_MODULE and sys.path."""
import os
import sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))


def bootstrap(sector_folder: str, settings_module: str) -> None:
    sector_path = os.path.join(ROOT, sector_folder)
    if ROOT not in sys.path:
        sys.path.insert(0, ROOT)
    if sector_path not in sys.path:
        sys.path.insert(0, sector_path)
    os.environ.setdefault("DJANGO_SETTINGS_MODULE", settings_module)
    import django
    from django.core.management import call_command

    if not django.apps.apps.ready:
        django.setup()
    call_command("makemigrations", "models", interactive=False, verbosity=0)
    call_command("migrate", interactive=False, verbosity=0)
