#!/bin/sh

set -e
set -x

get_timestamp() {
  date "+%Y-%m-%d %H:%M:%S %Z"
}

log_info() {
  echo "[$(get_timestamp)] [INFO] === $1 ==="
}

log_success() {
  echo "[$(get_timestamp)] [SUCCESS] $1"
}

log_warn() {
  echo "[$(get_timestamp)] [WARN] $1" >&2
}

error_exit() {
  echo ""
  echo "[$(get_timestamp)] [ERROR] !! FATAL: $1"
  echo "[$(get_timestamp)] [ERROR] !! Script aborted."
  set +x
  exit 1
}


log_info "Step 1: Stopping services..."
supervisorctl stop inventory-octane:inventory-octane_00

log_info "Step 2: Pulling latest code..."
echo "[$(get_timestamp)] [COMMAND] git pull origin main"
if git pull origin main; then
  log_success "Code pulled"
else
  error_exit "Git pull failed"
fi

log_info "Composer install latest version"
composer install

log_info "Optimize cache for all"
php artisan optimize:clear

log_info "Step 3: Starting services..."
supervisorctl reread
supervisorctl update
supervisorctl start inventory-octane:inventory-octane_00
