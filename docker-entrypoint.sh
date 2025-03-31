#!/bin/bash

cd /var/www

echo "🎉 Entrou no ENTRYPOINT com sucesso!"
echo "📁 Verificando se a pasta vendor existe..."

if [ ! -d "vendor" ]; then
  echo "🔧 Instalando dependências com composer..."
  composer install --no-interaction --prefer-dist
else
  echo "✅ Dependências já instaladas."
fi

APP_KEY_VALUE=$(grep "^APP_KEY=" .env | cut -d '=' -f2- | xargs)

if [ -z "$APP_KEY_VALUE" ]; then
  echo "🔐 Gerando APP_KEY do Laravel..."
  php artisan key:generate
else
  echo "🔐 APP_KEY já existe, mantendo a atual."
fi

# Espera o banco responder
echo "⏳ Aguardando banco de dados responder..."
until php artisan db:show >/dev/null 2>&1; do
  echo "⏳ Banco ainda não disponível, tentando novamente em 3s..."
  sleep 3
done

# Decide o que fazer com base no modo
if [ "$PROJECT_MODE" = "dev" ]; then
  echo "🧪 Modo DEV detectado: rodando migrate:fresh --seed"
  php artisan migrate:fresh --seed --force
elif [ "$PROJECT_MODE" = "prod" ]; then
  echo "🏭 Modo PROD detectado: aplicando migrations pendentes"
  php artisan migrate --force
else
  echo "⚠️  Modo desconhecido ($PROJECT_MODE). Nenhuma ação automática foi feita."
fi

echo "🔐 Corrigindo permissões das pastas storage e bootstrap/cache..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Executa o comando padrão (CMD do Dockerfile)
exec "$@"
