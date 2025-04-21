package Model_Chuong2_AWT_TKeGUI;

import java.awt.Button;
import java.awt.Color;
import java.awt.Dialog;
import java.awt.FlowLayout;
import java.awt.Frame;
import java.awt.GridLayout;
import java.awt.Label;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class DialogDemo_1_Layout extends Frame {

    Dialog d;
    Label l;
    Button b1, b2;

    public DialogDemo_1_Layout() {
        super("Demo Dialog!");
        this.setLayout(new FlowLayout());

        l = new Label("Chon hanh dong ban muon:");
        this.add(l);

        b1 = new Button("Add");
        this.add(b1);

        b2 = new Button("Delete");
        this.add(b2);

        d = new Dialog(this, "I'm a dialog!", true);
        d.setSize(300, 150);
        d.setLayout(new GridLayout(2, 1));
        d.add(new Label("Ban co chac chan muon xoa? Y/N"));
        d.add(new Button("Y"));
        d.add(new Button("N"));
        d.setVisible(false);

        // Phương thức bắt sự kiện click vào nút đóng frame
        this.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

    public void displyDialog() {
        d.setVisible(true);
    }

    public static void main(String[] args) {// Khai báo và khởi tạo frame có tiêu đề
        DialogDemo_1_Layout myFrame = new DialogDemo_1_Layout();
        myFrame.setSize(300, 150); // Định kích cỡ frame
        myFrame.setBackground(Color.LIGHT_GRAY);
        myFrame.setVisible(true);
    }
}
