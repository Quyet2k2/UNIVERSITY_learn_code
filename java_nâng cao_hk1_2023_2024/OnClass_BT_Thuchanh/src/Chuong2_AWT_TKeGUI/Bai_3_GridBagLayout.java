package Chuong2_AWT_TKeGUI;

import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.Font;
import java.awt.Frame;
import java.awt.GridBagConstraints;
import java.awt.GridBagLayout;
import java.awt.GridLayout;
import java.awt.Insets;
import java.awt.Panel;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JTextField;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author quyet
 */
public class Bai_3_GridBagLayout extends Frame {

    public Bai_3_GridBagLayout() {
        super("Nhập thông tin");
        this.setLayout(new GridBagLayout());
        Font font = new Font("Arial", Font.PLAIN, 16);
        this.setFont(font);

        GridBagConstraints gbc = new GridBagConstraints();
        Insets insets = new Insets(20, 0, 0, 0); // (top, left, bottom, right)

        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.gridx = 0;
        gbc.gridy = 0;

        Panel p = new Panel();
        p.setLayout(new GridLayout(3, 2));
        p.setPreferredSize(new Dimension(350, 100));
        this.add(p, gbc);

        Panel p2 = new Panel();
        FlowLayout f1 = new FlowLayout();
        f1.setAlignment(f1.CENTER);
        p2.setLayout(f1);
        p2.setPreferredSize(new Dimension(350, 40));
        gbc.gridy = 1;
        gbc.insets = insets;

        this.add(p2, gbc);

        p.add(new JLabel("Họ Tên: "));
        p.add(new JTextField(""));
        p.add(new JLabel("Địa Chỉ: "));
        p.add(new JTextField(""));
        p.add(new JLabel("Năm Sinh: "));
        p.add(new JTextField(""));
        p2.add(new JButton("Thêm"), gbc);
        p2.add(new JButton("Sửa"), gbc);
        p2.add(new JButton("Xóa"), gbc);
    }

    public static void main(String[] args) {
        Bai_3_GridBagLayout bai_3_GridBagLayout = new Bai_3_GridBagLayout();
        bai_3_GridBagLayout.setVisible(true);
        bai_3_GridBagLayout.setLocationRelativeTo(null);
        bai_3_GridBagLayout.pack();

        bai_3_GridBagLayout.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

}
