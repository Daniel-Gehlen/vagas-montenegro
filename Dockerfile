FROM php:8.2-alpine

WORKDIR /app

# Copia TODOS os arquivos mantendo a estrutura
COPY . .

# Verifica se os arquivos foram copiados
RUN echo "=== ARQUIVOS COPIADOS ===" && ls -la && echo "=== CONTEÚDO INDEX.PHP ===" && cat index.php

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "index.php"]
