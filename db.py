# db.py
import os
from datetime import datetime
from pymongo import MongoClient, ASCENDING, DESCENDING
from dotenv import load_dotenv

load_dotenv()

client = MongoClient(os.getenv("MONGODB_URI", "mongodb://localhost:27017"))
db = client[os.getenv("MONGO_DB", "noa")]
messages = db["messages"]

def ensure_indexes():
    messages.create_index([("message_id", ASCENDING)], unique=True)
    messages.create_index([("wa_id", ASCENDING), ("created_at", DESCENDING)])
    messages.create_index([("from_number", ASCENDING), ("to_number", ASCENDING), ("created_at", DESCENDING)])
ensure_indexes()

def now_utc():
    return datetime.utcnow()

def log_outbound(wa_id: str, body: str, msg_type: str, api_resp: dict, status_code: int):
    """Grava mensagem enviada (outbound)"""
    msg_id = None
    try:
        msg_id = api_resp.get("messages", [{}])[0].get("id")
    except Exception:
        pass

    doc = {
        "message_id": msg_id or f"local-{now_utc().timestamp()}",
        "wa_id": wa_id,                     # contato destino
        "from_number": None,                # (preenche se desejar guardar seu number)
        "to_number": wa_id,
        "direction": "outbound",
        "type": msg_type,                   # 'text' | 'template' | 'image' | ...
        "body": body,
        "media": [],
        "status": "sent" if status_code in (200,201) else "error",
        "api_status_code": status_code,
        "api_response": api_resp,
        "created_at": now_utc()
    }
    # upsert para evitar duplicata quando tiver message_id do Meta
    messages.update_one({"message_id": doc["message_id"]}, {"$setOnInsert": doc}, upsert=True)
    return doc["message_id"]

def update_status(message_id: str, new_status: str):
    """Atualiza status (usado pelo webhook: sent/delivered/read/failed)."""
    messages.update_one(
        {"message_id": message_id},
        {"$set": {"status": new_status, "last_status_at": now_utc()}}
    )
