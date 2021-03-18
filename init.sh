#!/bin/sh
host=`ip addr | grep /24 | awk '{print $2}' | awk -F '/' '{print $1}'`

context="HOST="$host"\n"

#获取控制台参数
while getopts "t:i:p:" opt; do
  case $opt in
    t)
      context=$context"CONSUL_CHECK_TYPE="$OPTARG"\n"
    ;;
    i)
      context=$context"CONSUL_CHECK_IP="$OPTARG"\n"
    ;;
    p)
      context=$context"CONSUL_CHECK_PORT="$OPTARG"\n"
    ;;
  esac
done

#生成.env配置文件
echo -e $context > /var/www/.env
