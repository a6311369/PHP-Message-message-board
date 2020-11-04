# Docker存提款使用方法

### Ordered

1. git clone 下來之後進入 [ tuffy_lin/docker ] 這個資料夾
2. 執行 [ docker-compose up --build -d ] ,等待執行完畢
3. 確認docker是否正常運作 [ docker ps -a ] ,確認都正常執行後繼續下一步
4. 進入contanier [ docker exec -it nginx-php7.3 /bin/bash ]
5. 進入容器後切換目錄 [ cd /opt/tuffy_lin/docker_symfony/ ]
6. 執行 [ composer update ] 靜待完成
7. 直到出現一個要輸入 DB ip的畫面時 ( 該畫面會有出現 127.0.0.1 這個字眼時就是了)，輸入DB Contanier的IP與帳號密碼 
  1. ip : 10.10.10.4
  2. port : 3306
  3. database_name: symfony
  4. database_name: symfony
  5. database_password: 1Q2w3e4R
  6. ....其他的都按enter即可
8. 切換目錄至 [ /opt/tuffy_lin/docker_symfony/var ] ，修改目錄權限 [ chmod -R 777 cache logs sessions ]
9. 離開容器，設定hosts zzz.com 這個domain指向至虛擬機的IP
10. 測試運作方式
  1. 瀏覽器 輸入 zzz.com 如出現 Welcome to Symfony .....等字眼及代表連線成功
  2. 存款方式 http://zzz.com/bank/deposit?id=3&depositMoney=10
  3. 提款方式 http://zzz.com/bank/withdraw?id=1&withdrawMoney=50
  4. Redis寫入DB http://zzz.com/writetodb/writetodb
