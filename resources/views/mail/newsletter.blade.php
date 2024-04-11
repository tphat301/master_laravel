<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Mail đăng ký nhận tin</title>
</head>
<body>
  <div>
    <table class="table__mail">
      <tbody>
        <tr>
          <td>
              <h1 class="table__mail--titleMain" style="font-size: 20px">
                Chào {{!empty($fullname) ? $fullname : 'Your name'}}!.
              </h1>
              <p class="table__mail--subTitle">
                Chúng tôi đã xác nhận thông tin mà bạn đã đăng ký và sẽ tiến hành liên lạc với bạn sớm nhất (có thể)
              </p>
          </td>
        </tr>
        <tr>
          <td class="table__mail--bxTbl">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <thead>
                <tr>
                  <th class="table__mail--thDev" width="50%" align="left">
                    Thông tin khách hàng
                  </th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td class="mail__fullname" valign="top">
                      <span><strong>Họ và tên:</strong> {{!empty($fullname) ? $fullname : 'Your name'}}</span><br>
                      <a><strong>Email:</strong> {{!empty($email) ? $email : 'abc@gmail.com'}}</a><br> <strong>Số điện thoại:</strong> {{!empty($phone) ? $phone : '0987654321'}}
                    </td>
                  </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
            <td>
                <br>
                <p class="mail__alert">Quý khách vui lòng giữ lại hóa đơn (nếu có) để trao đổi hoặc khiếu nại khi cần thiết.</p>
                <p class="mail__infomation">Liên hệ với chúng tôi qua số hotline: <strong>{{!empty($hotline) ? $hotline : '0987654321'}}</strong><br>Giờ làm việc:(8-21h cả T7,CN).</p>
            </td>
        </tr>
        <tr>
          <td>
            <br>
            <p class="mail__thanks">
              <span>{{$name_company}}</span> cảm ơn quý khách đã đăng ký, chúng tôi sẽ không ngừng nổ lực để phục vụ quý khách tốt hơn!<br>
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
