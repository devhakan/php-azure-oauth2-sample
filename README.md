# Azure AD OAuth2 ile PHP Kimlik Doğrulama Uygulaması

## Proje Hakkında
Bu proje, Microsoft Azure Active Directory kullanarak OAuth2 kimlik doğrulaması yapan basit bir PHP uygulamasıdır. Kullanıcılar, Microsoft hesaplarıyla güvenli bir şekilde giriş yapabilirler.

## Gereksinimler
- PHP 7.4 veya üzeri
- Composer
- Microsoft Azure hesabı ve kayıtlı bir uygulama

## Kurulum
1. Projeyi klonlayın:
```bash
git clone [proje-url]
cd [proje-dizini]
```

2. Bağımlılıkları yükleyin:
```bash
composer install
```

3. `.env` dosyasını oluşturun ve gerekli bilgileri ekleyin:
```env
AZURE_AD_CLIENT_ID=your_client_id
AZURE_AD_CLIENT_SECRET=your_client_secret
AZURE_AD_TENANT_ID=your_tenant_id
REDIRECT_URI=http://localhost:8000/callback.php
ALLOWED_DOMAINS=domain1.com,domain2.com
```

ALLOWED_DOMAINS değişkeni, kimlik doğrulaması yapılmış olsa bile hangi e-posta domainlerinin uygulamaya erişebileceğini belirler. Birden fazla domain için virgülle ayırarak yazabilirsiniz.

## Azure Portal Yapılandırması
1. Azure Portal'da yeni bir uygulama kaydı oluşturun
2. Uygulama (client) ID, dizin (tenant) ID ve client secret değerlerini not alın
3. Yetkilendirme için aşağıdaki izinleri ekleyin:
   - User.Read
   - offline_access
4. Yönlendirme URI'sini (callback URL) ekleyin: `http://localhost:8000/callback.php`

## Uygulamayı Çalıştırma
1. PHP'nin dahili web sunucusunu başlatın:
```bash
php -S localhost:8000
```

2. Tarayıcınızda `http://localhost:8000` adresine gidin

## Özellikler
- Microsoft hesabı ile güvenli giriş
- Kullanıcı profil bilgilerine erişim
- Oturum yönetimi

## Güvenlik Notları
- `.env` dosyasını asla versiyon kontrolüne eklemeyin
- Client secret'ı güvenli bir şekilde saklayın
- HTTPS kullanımı önerilir

## Sorun Giderme
1. Giriş yapılamıyorsa:
   - Azure Portal'daki uygulama ayarlarını kontrol edin
   - `.env` dosyasındaki bilgilerin doğruluğunu kontrol edin
   - Yönlendirme URI'sinin doğru yapılandırıldığından emin olun

2. Oturum sorunları:
   - PHP session ayarlarını kontrol edin
   - Tarayıcı çerezlerinin etkin olduğundan emin olun

## Katkıda Bulunma
Projeye katkıda bulunmak için:
1. Bu depoyu fork edin
2. Yeni bir özellik dalı oluşturun (`git checkout -b yeni-ozellik`)
3. Değişikliklerinizi commit edin (`git commit -am 'Yeni özellik eklendi'`)
4. Dalınıza push yapın (`git push origin yeni-ozellik`)
5. Bir Pull Request oluşturun

## Lisans
Bu proje MIT lisansı altında lisanslanmıştır.