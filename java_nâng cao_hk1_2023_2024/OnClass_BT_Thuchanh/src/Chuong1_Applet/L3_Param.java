package Chuong1_Applet;

import java.applet.Applet;
import java.awt.Graphics;

public class L3_Param extends Applet {
    public void paint(Graphics g) {
        // Lấy giá trị tham số từ file HTML
        String bien1 = getParameter("bien1");
        String bien2 = getParameter("bien2");

        // Kiểm tra xem giá trị tham số có phải là null hay không
        if (bien1 != null && bien2 != null) {
            try {
                // Chuyển đổi giá trị tham số thành số nguyên
                int value1 = Integer.parseInt(bien1);
                int value2 = Integer.parseInt(bien2);

                // Tính tổng của hai giá trị tham số
                int sum = value1 + value2;

                // In tổng lên màn hình
                g.drawString("Tổng của " + value1 + " và " + value2 + " là: " + sum, 50, 50);
            } catch (NumberFormatException e) {
                g.drawString("Lỗi: Không thể chuyển đổi thành số nguyên", 50, 50);
            }
        } else {
            g.drawString("Lỗi: Giá trị tham số không được cung cấp", 50, 50);
        }
    }
}


/*
<applet code="L3_Param.class" width="600" height="500">
        <param name="bien1" value="12">
        <param name="bien2" value="18">
    </applet>
*/