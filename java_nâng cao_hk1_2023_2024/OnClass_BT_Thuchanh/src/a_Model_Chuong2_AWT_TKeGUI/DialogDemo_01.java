/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Model_Chuong2_AWT_TKeGUI;

import java.awt.Button;
import java.awt.Dialog;
import java.awt.FlowLayout;
import java.awt.Frame;
import java.awt.Label;
import java.awt.TextField;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
class MessageBox {
    Dialog msgBox;
    
    MessageBox(Frame parentWindow, String msg, String title) {

        if (parentWindow == null) {
            Frame emptyWindow = new Frame();
            msgBox = new Dialog(emptyWindow, title, true);
        } else {
            msgBox = new Dialog(parentWindow, title, true);
        }
        Label Message = new Label(msg);
        Button button = new Button("YES");
        button.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent event) {
                msgBox.setVisible(false);
            }
        });
        msgBox.setLayout(new FlowLayout());
        msgBox.add(Message);
        msgBox.add(button);
        msgBox.setSize(200, 100);
    }

    public void show() {
       
        msgBox.setVisible(true);

    }
}

public class DialogDemo_01 extends Frame {

    TextField textfield1;
    Button button;

    DialogDemo_01() {
        super("Demo Dialog");
        // Dialog myDialog = new Dialog(this, "My Dialog", true);
        textfield1 = new TextField(9);
        button = new Button("Nhập Nội Dung");
        button.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                System.out.println("text: " + textfield1.getText());
                if (textfield1.getText().length() == 0) {
                    MessageBox msg = new MessageBox(null, "Xâu rỗng", "Thông báo");
                    msg.show();
                } else {
                    System.out.print("khong rong " + textfield1.getText().length() + "-");
                }
            }

        });
        this.setLayout(new FlowLayout());
        this.add(textfield1);
        this.add(button);
        this.setSize(200, 300);
        this.setVisible(true);
        this.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });

    }

    public static void main(String args[]) {
        new DialogDemo_01();

    }

}
