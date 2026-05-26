from services.shipment_builder import build_shipment
from services.certification_checker import pre_shipment_check


def build_and_check(batch_ids, buyer_id, destination_country, departure_date) -> dict:
    shipment = build_shipment(batch_ids, buyer_id, destination_country, departure_date)
    check = pre_shipment_check(str(shipment.shipment_id))
    return {"shipment_id": str(shipment.shipment_id), "compliance": check}
