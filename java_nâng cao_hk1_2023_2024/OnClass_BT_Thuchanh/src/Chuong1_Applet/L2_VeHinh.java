package Chuong1_Applet;

import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.net.URL;

public class L2_VeHinh extends Applet {
    private Image backgroundImage;

    public void init() {
        // Load background image
        try {
            URL imageURL = new URL(getCodeBase(), "./Chuong1_Applet/background.jpg"); // Điều chỉnh tên file ảnh và đường dẫn tương ứng
//            URL imageURL = new URL(getCodeBase(), "./background.jpg"); // Điều chỉnh tên file ảnh và đường dẫn tương ứng
            backgroundImage = getImage(imageURL);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void paint(Graphics g) {
         setSize(1922/2, 1082/2); // Đặt kích thước cho cửa sổ
        // Đặt nền là hình ảnh nền
        if (backgroundImage != null) {
            g.drawImage(backgroundImage, 0, 0, getWidth(), getHeight(), this);
        }

        // Vẽ hình vuông với các cạnh khác màu
        g.setColor(Color.RED);
        g.fillRect(50, 50, 100, 100);

        g.setColor(Color.GREEN);
        g.fillRect(200, 50, 100, 100);

        g.setColor(Color.BLUE);
        g.fillRect(350, 50, 100, 100);

        // Vẽ hình chữ nhật có các cạnh đồng màu
        g.setColor(Color.YELLOW);
        g.fillRect(50, 200, 150, 100);

        // Vẽ và tô màu cho hình chữ nhật
        g.setColor(Color.ORANGE);
        g.drawRect(250, 200, 150, 100);
        g.fillRect(250, 200, 150, 100);

        // Vẽ hình tam giác có các cạnh đồng màu
        int[] xPoints = {550, 700, 625};
        int[] yPoints = {200, 200, 100};
        g.setColor(Color.PINK);
        g.fillPolygon(xPoints, yPoints, 3);
    }
}

