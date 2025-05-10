#!/bin/bash

FILE="config.php"

# Ambil baris yang ada versi-nya
line=$(grep "\$version" $FILE)

# Ambil versinya (misal 1.0.3)
version=$(echo $line | grep -oP "'\K[0-9.]+")

# Pisah jadi array
IFS='.' read -ra parts <<< "$version"

# Naikkan patch (angka terakhir)
patch=$((parts[2] + 1))

# Versi baru
new_version="${parts[0]}.${parts[1]}.$patch"

# Replace versi lama ke baru
sed -i "s/\$version = '.*';/\$version = '$new_version';/" $FILE

echo "Updated PHP version: $version → $new_version"
