from services.moh_report_generator import build_quarterly_moh_report


def get_moh_quarterly(quarter: str) -> dict:
    return build_quarterly_moh_report(quarter)
