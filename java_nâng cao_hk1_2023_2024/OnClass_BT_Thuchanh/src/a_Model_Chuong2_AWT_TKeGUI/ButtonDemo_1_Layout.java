package Model_Chuong2_AWT_TKeGUI;

import java.awt.Button;
import java.awt.Color;
import java.awt.Frame;
import java.awt.GridLayout;
import java.awt.Label;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class ButtonDemo_1_Layout extends Frame {

    Button b1, b2;
    Label l;

    public ButtonDemo_1_Layout() {
        super("Demo Layout");
        this.setLayout(new GridLayout(2, 2));

        b1 = new Button("Click1");
        this.add(b1);

        b2 = new Button("Click2");
        this.add(b2);

        l = new Label("Day la Label");
        this.add(l);
        // Phương thức bắt sự kiện click vào nút đóng frame
        this.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

    public static void main(String[] args) {
        ButtonDemo_1_Layout f = new ButtonDemo_1_Layout();
        f.setSize(500, 150);
        f.setBackground(Color.lightGray);
        f.setVisible(true);
    }
}
