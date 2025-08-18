# send_template.py
from whatsapp import send_template

if __name__ == "__main__":
    # Exemplo sem variáveis:
    print(send_template("5546991257620", "Teste de mensagem", "en_US"))

    # Exemplo com variáveis/parameters (se seu template tiver placeholders):
    # components = [{
    #   "type": "body",
    #   "parameters": [
    #       {"type": "text", "text": "Elder"},
    #       {"type": "text", "text": "12/08 14:00"}
    #   ]
    # }]
    # print(send_template("5546991257620", "seu_template_aprovado", "pt_BR", components))
