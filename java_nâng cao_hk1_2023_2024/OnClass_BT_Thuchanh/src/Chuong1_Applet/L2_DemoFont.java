package Chuong1_Applet;

import java.applet.Applet;
import java.awt.Font;
import java.awt.Graphics;

public class L2_DemoFont extends Applet {
    public void init() {
        setSize(600, 500);
    }

    public void paint(Graphics g) {
        Font font = new Font("Arial", Font.ITALIC, 16);
        g.setFont(font);
        
        String text = "Xin chào, phông chữ của tôi là Arial, italic, size 16";
        g.drawString(text, 50, 50);
    }
}
