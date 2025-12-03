#!/bin/bash

# ПРИМЕРЫ
# Актуализировать до ветки мастер:
# sh update.sh
#
# Актуализировать до ветки ing-2001:
# sh update.sh ing-2001

# Checking modified files
if ! git diff --quiet
then
  echo "!!! YOU HAVE MODIFIED FILES. ABORTED !!!"
  exit
fi

BRANCH=$(git symbolic-ref --short -q HEAD)
if [ -n "$1" ]
then
  BRANCH=$1
fi
echo === UPDATE TO ${BRANCH} ===

confirm() {
    # call with a prompt string or use a default
    read -r -p "${1:-Are you sure? [y/N]} " response
    case "$response" in
        [yY][eE][sS]|[yY])
            true
            ;;
        *)
            false
            ;;
    esac
}

confirm || exit 0

git reset --hard && git fetch && git checkout ${BRANCH} && git reset --hard origin/$BRANCH

echo "=== Checking prestissimo is installed (to boost composer install)"
if composer global show | grep -q "prestissimo"
  then echo "Prestissimo already installed"
  else composer global require hirak/prestissimo
fi
echo "=== Prestissimo check end"

composer install --no-dev --optimize-autoloader --no-interaction
php yii migrate

# очистку кэша пока убрали. Нужно разделить кэш,
# чтобы то что получено из инсты кэшировалось в другой кэш, который бы не очищался при деплое
# php yii cache/flush-all