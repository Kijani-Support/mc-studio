## Quick orientation for code-assist agents

This repository contains two major areas you should understand before editing:

- Monocle (core library & tools): `monocle-main/monocle-main/` — instrumentation, metamodels, an MCP server and test tools for tracing GenAI apps. See `monocle-main/monocle-main/README.md` and `monocle-main/monocle-main/test_tools/README.md` for usage patterns and examples.
- A Django example/service: `Kijani_EventAPI/` — a small Django REST project used as an integration/example. Key files: `Kijani_EventAPI/settings.py`, `Kijani_EventAPI/manage.py`, `Kijani_EventAPI/requirements.txt`.

Keep changes minimal and testable. The project uses plain Python (virtualenv) and pytest-style tests for validation.

Key things to know (actionable):

- How traces are created: import and call the instrumentor in app entry points. Example (from README):

  from monocle_apptrace.instrumentor import setup_monocle_telemetry
  setup_monocle_telemetry(workflow_name="your-app-name")

- Metamodel & span format: spans and canonical fields live under `src/monocle_apptrace/metamodel/` (e.g. `src/monocle_apptrace/metamodel/spans/span_format.json`). Use these files as the source of truth when generating or validating spans.

- Test conventions: Monocle provides a test harness (`monocle_test_tools`). Tests define `TestCase` objects (dicts) and may use the `@MonocleValidator().monocle_testcase(...)` decorator. See `monocle-main/monocle-main/test_tools/README.md` and `tests/integration/test_adk_travel_agent.py` for examples.

- Django integration: `Kijani_EventAPI` uses Django REST Framework with project-specific hooks:
  - Custom pagination: `EventAPI.pagination.CustomPagination`
  - Custom exception handler: `EventAPI.exceptions.custom_exception_handler`
  When modifying API behavior, check `EventAPI/pagination.py`, `EventAPI/exceptions.py`, and `EventAPI/views.py`.

Developer / agent workflow (Windows PowerShell examples)

1. Create and activate venv

```powershell
python -m venv .venv
.\.venv\Scripts\Activate.ps1
```

2. Install dependencies (install from relevant subfolders)

```powershell
pip install -r Kijani_EventAPI/requirements.txt
pip install -r monocle-main\monocle-main\requirements.txt
```

3. Run Django dev server (for `Kijani_EventAPI` example)

```powershell
cd Kijani_EventAPI
python manage.py migrate
python manage.py runserver
```

4. Run unit/integration tests

```powershell
# from repo root
pip install pytest
pytest -q
```

Project-specific conventions and patterns

- Instrumentation-first: code changes that affect AI/agent behavior should include or preserve Monocle instrumentation so traces remain consistent. Prefer adding instrumentation via `setup_monocle_telemetry` rather than creating ad-hoc logging.
- Tests validate traces, not only outputs: many tests assert the presence and contents of spans (span types like `agentic.tool.invocation` and entity lists). When adjusting code paths, update expected test spans in `tests/` accordingly.
- Exporter config is externalized: Monocle supports multiple exporters (stdout, file, memory, Azure/S3, OTEL). Look for config hooks in `src/monocle_apptrace` and any `config` or `settings` helpers.
- Django defaults are dev-friendly: `DEBUG=True`, SQLite database (db.sqlite3). Secrets in `Kijani_EventAPI/settings.py` are for development; do not promote them to production.

Integration points and external dependencies

- Core Python deps: see `Kijani_EventAPI/requirements.txt` and `monocle-main/monocle-main/requirements.txt`.
- Telemetry and exporters: OTEL-compatible collectors, cloud storage exporters; check `src/monocle_apptrace/exporters` (or similar) for exact integration code.
- MCP server & tooling: `monocle-main/monocle-main/mcp/` contains the MCP server used for curated prompts and tooling. Use it to run developer tooling prompts and local analysis.

When making edits

- Keep changes small and verifiable. Run related tests locally and ensure any changed traces conform to `src/monocle_apptrace/metamodel/*` files.
- If you touch API pagination/exception behavior, update or add tests in `Kijani_EventAPI/tests` or `monocle-main/monocle-main/tests` demonstrating the desired span behavior.

Files to inspect first (examples):

- `monocle-main/monocle-main/README.md`
- `monocle-main/monocle-main/test_tools/README.md`
- `monocle-main/monocle-main/src/monocle_apptrace/metamodel/spans/span_format.json`
- `Kijani_EventAPI/settings.py`, `Kijani_EventAPI/manage.py`, `Kijani_EventAPI/requirements.txt`
- `EventAPI/pagination.py`, `EventAPI/exceptions.py`, `EventAPI/views.py`

If any section here is unclear or you need a deeper dive (examples of common span shapes, specific exporter config, or where tests assert spans), tell me which area to expand and I'll update this file.
