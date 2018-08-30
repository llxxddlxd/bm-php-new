# bm-php-zjl
## php-sdk for bumo

## 需要注意地方
1. 生成随机数的算法，要求 php版本<=5.6
2. 需要环境包含ed25519的php库 , \libs\ed25519.so
3. 注意服务器日志的用户组与，src\loginfo，需要apache可操作
4. 新添加base.php文件，基类
5. 新添加autoload.php文件，自动加载所需文件

## 关于transaction 的修改
1.buildBlob(多入参、单数组出参)与buildBlobObject（入参出参皆对象，与原文档一样)
2.sign(多入参、单数组出参)与signObject（入参出参皆对象，与原文档一样）
3.submit(多入参、单数组出参)与submitObject（入参出参皆对象，与原文档一样）

>>针对第一种的测试用例，请看：account\setMetadata()接口，例子：accountTest.php?type=3
>>针对第二种的测试用例，请看：account\activate()接口，例子：accountTest.php?type=2
