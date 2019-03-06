package csuf.amse.ois;

import static org.hamcrest.CoreMatchers.is;
import static org.hamcrest.CoreMatchers.not;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertThat;

import java.util.List;
import java.util.concurrent.TimeUnit;

import org.apache.log4j.Level;
import org.apache.log4j.Logger;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.NoAlertPresentException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

public class OIS003DeleteClientTest {
	private static org.apache.log4j.Logger log = Logger.getLogger(OIS002EditClientTest.class);

	private WebDriver driver;
	private WebDriverWait wait;
	private String baseUrl = "http://localhost:8080/online-invoicing-system";
	private boolean acceptNextAlert = true;

	@Before
	public void setUp() throws Exception {
		log.setLevel(Level.INFO);

		System.out.println("\n\n================================================================================");
		System.out.println("Test Case: OIS-003\n" + "Test Case Description: Delete an existing client in the system \n"
				+ "Author: Tawin\n");
		System.out.println("================================================================================");
		
//		System.out.println("<Setup> \n" + "Setup WebDriver");

		System.out.println("Testing on: Chrome");
		System.setProperty("webdriver.chrome.driver", "D:\\selenium workspace\\drivers\\chromedriver.exe");
		DesiredCapabilities capabilities = DesiredCapabilities.chrome();
		ChromeOptions options = new ChromeOptions();
		options.addArguments("test-type");
		options.addArguments("start-maximized");
		options.addArguments("user-data-dir=D:/temp/");
		capabilities.setCapability("chrome.binary", "D:\\\\selenium workspace\\\\drivers\\\\chromedriver.exe");
		capabilities.setCapability(ChromeOptions.CAPABILITY, options);
		driver = new ChromeDriver(capabilities);
		driver.manage().window().maximize();

		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);

		wait = new WebDriverWait(driver, 10);
	}

	@Test
	public void testDeleteClient() throws Exception {
		System.out.println("The steps of testing");

		System.out.println("\t1-Launch the application");
		this.driver.get(baseUrl + "/index.php");
		assertEquals("Redirect to wrong page", baseUrl + "/index.php", driver.getCurrentUrl());

		System.out.println("\t2-Go to Clients page");
		driver.findElement(By.linkText("Clients")).click();
		assertEquals("Redirect to wrong page", baseUrl + "/clients_view.php", driver.getCurrentUrl());

		// store total number of clients that will be used to compare
		int prevCAmt = getTotalClients();

		System.out.println("\t3-Select the target Client");
		WebElement selectedRow = driver
				.findElement(By.xpath("html/body/div[1]/div[4]/div[1]/form/div[3]/div/div[1]/table/tbody/tr[2]"));
		List<WebElement> selectedRowChilds = selectedRow.findElements(By.xpath(".//*"));
		String name = selectedRowChilds.get(3).getAttribute("innerHTML");
		String contact = selectedRowChilds.get(5).getAttribute("innerHTML");
		String title = selectedRowChilds.get(7).getAttribute("innerHTML");
		String address = selectedRowChilds.get(9).getAttribute("innerHTML");
		String city = selectedRowChilds.get(11).getAttribute("innerHTML");
		String country = selectedRowChilds.get(13).getAttribute("innerHTML");
		String phone = selectedRowChilds.get(15).getAttribute("innerHTML");
		String email = selectedRowChilds.get(17).getAttribute("title");
		String website = selectedRowChilds.get(20).getAttribute("innerHTML");
		System.out.println("\t\tSelected Data:");
		System.out.println("\t\tName: " + name);
		System.out.println("\t\tContact: " + contact);
		System.out.println("\t\tTitle: " + title);
		System.out.println("\t\tAddress: " + address);
		System.out.println("\t\tCity: " + city);
		System.out.println("\t\tCountry: " + country);
		System.out.println("\t\tPhone: " + phone);
		System.out.println("\t\tEmail: " + email);
		System.out.println("\t\tWebsite: " + website);
		selectedRowChilds.get(3).click();
		assertThat(driver.findElement(By.id("id")).getAttribute("innerHTML"), is(not("")));

		System.out.println("\t4-Delete Selected Client");
		wait.until(ExpectedConditions.elementToBeClickable(By.id("delete")));
		driver.findElement(By.id("delete")).sendKeys(Keys.ENTER);
		isAlertPresent();

		System.out.println("\t5-Confirm deleting");
		closeAlertAndGetItsText();

		System.out.println("\n17-Verify deleting the selected client result");

		System.out.println("\t17.1-Check returned message");
		WebElement messageDiv = driver.findElement(By.xpath("html/body/div[1]/div[3]"));
		List<WebElement> mDivChilds = messageDiv.findElements(By.xpath(".//*"));
		String returnMsg = mDivChilds.get(0).getAttribute("innerHTML");
		returnMsg = returnMsg.replaceAll("(<([^*]+)>)", "");
		System.out.println("\t\tReturned Message:" + returnMsg);
		assertEquals("The record has been deleted successfully", returnMsg);

		System.out.println("\t17.2-Check total clients number");
		int currentCAmt = getTotalClients();
		System.out.println("\t\tTotal clients: " + prevCAmt + "->" + currentCAmt);
		assertThat(currentCAmt, is(prevCAmt - 1));
	}

	@After
	public void tearDown() throws Exception {
		driver.quit();
	}

	private int getTotalClients() {
		String[] navDetail = driver
				.findElement(By.xpath("html/body/div[1]/div[4]/div[1]/form/div[3]/div/div[1]/table/tfoot/tr/td"))
				.getAttribute("innerHTML").split(" ");
		return Integer.parseInt(navDetail[navDetail.length - 1]);
	}

	private boolean isAlertPresent() {
		try {
			driver.switchTo().alert();
			return true;
		} catch (NoAlertPresentException e) {
			return false;
		}
	}

	private String closeAlertAndGetItsText() {
		try {
			Alert alert = driver.switchTo().alert();
			String alertText = alert.getText();
			if (acceptNextAlert) {
				alert.accept();
			} else {
				alert.dismiss();
			}
			return alertText;
		} finally {
			acceptNextAlert = true;
		}
	}
}
