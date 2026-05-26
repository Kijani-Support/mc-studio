from models.export_shipment import ExportShipment


def build_shipment(batch_ids: list, buyer_id: str, destination_country: str, departure_date) -> ExportShipment:
    return ExportShipment.objects.create(
        batch_ids=[str(b) for b in batch_ids],
        buyer_id=buyer_id,
        destination_country=destination_country,
        departure_date=departure_date,
    )
