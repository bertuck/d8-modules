#!/usr/bin/env sh
#used for pipeline

mkdir .public
cp -r include .public
cp index.html .public
cp packages.json .public
mv .public public

chown -R 1001:1001 .

