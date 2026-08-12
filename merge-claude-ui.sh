#!/usr/bin/env bash

set -Eeuo pipefail

# ============================================================
# Travel Agent - Safe Claude UI Merge
# ============================================================

PROJECT_DIR="$(pwd)"
ZIP_FILE="${1:-travel-agent-customer-ui.zip}"

WORK_DIR="$(mktemp -d)"
CLAUDE_DIR="$WORK_DIR/claude"
BACKUP_DIR="$PROJECT_DIR/.merge-backup-$(date +%Y%m%d-%H%M%S)"

cleanup() {
    rm -rf "$WORK_DIR"
}

trap cleanup EXIT

echo "=============================================="
echo " Travel Agent - Claude UI Safe Merge"
echo "=============================================="
echo

# ------------------------------------------------------------
# 1. Validate project
# ------------------------------------------------------------

if [[ ! -f "$PROJECT_DIR/artisan" ]]; then
    echo "ERROR: Script harus dijalankan dari root Laravel project."
    exit 1
fi

if [[ ! -f "$PROJECT_DIR/composer.json" ]]; then
    echo "ERROR: composer.json tidak ditemukan."
    exit 1
fi

if [[ ! -f "$ZIP_FILE" ]]; then
    echo "ERROR: ZIP tidak ditemukan:"
    echo "       $ZIP_FILE"
    exit 1
fi

# ------------------------------------------------------------
# 2. Extract Claude ZIP
# ------------------------------------------------------------

echo "[1/7] Extract hasil Claude..."

mkdir -p "$CLAUDE_DIR"

unzip -q "$ZIP_FILE" -d "$CLAUDE_DIR"

# Handle ZIP yang punya wrapper directory
CLAUDE_ROOT="$CLAUDE_DIR"

if [[ ! -f "$CLAUDE_ROOT/artisan" ]]; then
    FOUND_ROOT="$(find "$CLAUDE_DIR" -maxdepth 2 -type f -name artisan -print -quit || true)"

    if [[ -n "$FOUND_ROOT" ]]; then
        CLAUDE_ROOT="$(dirname "$FOUND_ROOT")"
    fi
fi

echo "Claude project:"
echo "  $CLAUDE_ROOT"
echo

# ------------------------------------------------------------
# 3. Backup
# ------------------------------------------------------------

echo "[2/7] Membuat backup..."

mkdir -p "$BACKUP_DIR"

# Backup resources
if [[ -d "$PROJECT_DIR/resources" ]]; then
    cp -a "$PROJECT_DIR/resources" "$BACKUP_DIR/"
fi

# Backup routes/web.php
if [[ -f "$PROJECT_DIR/routes/web.php" ]]; then
    mkdir -p "$BACKUP_DIR/routes"
    cp -a "$PROJECT_DIR/routes/web.php" "$BACKUP_DIR/routes/"
fi

# Backup controllers
if [[ -d "$PROJECT_DIR/app/Http/Controllers" ]]; then
    mkdir -p "$BACKUP_DIR/app/Http"
    cp -a "$PROJECT_DIR/app/Http/Controllers" "$BACKUP_DIR/app/Http/"
fi

echo "Backup:"
echo "  $BACKUP_DIR"
echo

# ------------------------------------------------------------
# 4. Show protected directories
# ------------------------------------------------------------

echo "[3/7] Protected directories:"
echo
echo "  database/       PROTECTED"
echo "  app/Models/     PROTECTED"
echo "  app/Services/   PROTECTED"
echo "  app/Filament/   PROTECTED"
echo "  config/         PROTECTED"
echo "  .env            PROTECTED"
echo "  vendor/         PROTECTED"
echo "  routes/auth.php PROTECTED"
echo

# ------------------------------------------------------------
# 5. Resources
# ------------------------------------------------------------

echo "[4/7] Sync resources..."

if [[ -d "$CLAUDE_ROOT/resources/views" ]]; then
    echo "  → resources/views"

    rsync -av \
        --exclude='.DS_Store' \
        "$CLAUDE_ROOT/resources/views/" \
        "$PROJECT_DIR/resources/views/"
fi

if [[ -d "$CLAUDE_ROOT/resources/css" ]]; then
    echo "  → resources/css"

    rsync -av \
        --exclude='.DS_Store' \
        "$CLAUDE_ROOT/resources/css/" \
        "$PROJECT_DIR/resources/css/"
fi

if [[ -d "$CLAUDE_ROOT/resources/js" ]]; then
    echo "  → resources/js"

    rsync -av \
        --exclude='.DS_Store' \
        "$CLAUDE_ROOT/resources/js/" \
        "$PROJECT_DIR/resources/js/"
fi

echo

# ------------------------------------------------------------
# 6. Controllers
# ------------------------------------------------------------

echo "[5/7] Merge controller baru..."

if [[ -d "$CLAUDE_ROOT/app/Http/Controllers" ]]; then

    rsync -av \
        --ignore-existing \
        --exclude='.DS_Store' \
        "$CLAUDE_ROOT/app/Http/Controllers/" \
        "$PROJECT_DIR/app/Http/Controllers/"

    echo
    echo "CATATAN:"
    echo "Controller yang SUDAH ADA tidak ditimpa."
    echo "Controller BARU saja yang disalin."
fi

echo

# ------------------------------------------------------------
# 7. Routes diff
# ------------------------------------------------------------

echo "[6/7] Memeriksa routes/web.php..."

if [[ -f "$CLAUDE_ROOT/routes/web.php" ]]; then

    ROUTE_DIFF="$PROJECT_DIR/claude-web-routes.diff"

    diff -u \
        "$PROJECT_DIR/routes/web.php" \
        "$CLAUDE_ROOT/routes/web.php" \
        > "$ROUTE_DIFF" || true

    echo
    echo "Diff route dibuat:"
    echo "  $ROUTE_DIFF"
    echo
    echo "JANGAN overwrite routes/web.php secara otomatis."
    echo "Review diff tersebut secara manual."
fi

echo

# ------------------------------------------------------------
# 8. Final report
# ------------------------------------------------------------

echo "[7/7] Merge selesai."
echo
echo "=============================================="
echo " HASIL MERGE"
echo "=============================================="
echo
echo "Yang sudah di-sync:"
echo "  ✓ resources/views"
echo "  ✓ resources/css"
echo "  ✓ resources/js"
echo
echo "Controller:"
echo "  ✓ hanya controller BARU"
echo "  ✓ controller lama TIDAK ditimpa"
echo
echo "Routes:"
echo "  ! routes/web.php TIDAK diubah"
echo "  ! review claude-web-routes.diff"
echo
echo "Protected:"
echo "  ✓ database/"
echo "  ✓ app/Models/"
echo "  ✓ app/Services/"
echo "  ✓ app/Filament/"
echo "  ✓ config/"
echo "  ✓ .env"
echo "  ✓ vendor/"
echo "  ✓ routes/auth.php"
echo
echo "Backup:"
echo "  $BACKUP_DIR"
echo

echo "Langkah berikutnya:"
echo
echo "  git status"
echo "  git diff"
echo "  cat claude-web-routes.diff"
echo
echo "JANGAN jalankan migrate:fresh."
echo
