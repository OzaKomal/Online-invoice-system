package csuf.amse.ois;

import static org.hamcrest.CoreMatchers.is;
import static org.hamcrest.CoreMatchers.not;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertThat;

import java.util.List;
import java.util.concurrent.TimeUnit;

import org.apache.log4j.Level;
import org.apache.log4j.Logger;
import org.junit.*;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

public class OIS002EditClientTest {
	private static org.apache.log4j.Logger log = Logger.getLogger(OIS002EditClientTest.class);

	private WebDriver driver;
	private WebDriverWait wait;
	private String baseUrl = "http://localhost:8080/online-invoicing-system";

	@Before
	public void setUp() throws Exception {
		log.setLevel(Level.INFO);

		System.out.println("\n\n================================================================================");
		System.out.println("Test Case: OIS-002\n" + "Test Case Description: Edit an existing client in the system \n" + "Author: Tawin\n");
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
	public void testEditClient() throws Exception {
		System.out.println("The steps of testing");

		System.out.println("\t1-Launch the application");
		this.driver.get(baseUrl + "/index.php");
		assertEquals("Redirect to wrong page", baseUrl + "/index.php", driver.getCurrentUrl());

		System.out.println("\t2-Go to Clients page");
		driver.findElement(By.linkText("Clients")).click();
		assertEquals("Redirect to wrong page", baseUrl + "/clients_view.php", driver.getCurrentUrl());

		System.out.println("\t3-Open editing Client form");
		// store old data that will be used to compare
		WebElement selectedRow = driver
				.findElement(By.xpath("html/body/div[1]/div[4]/div[1]/form/div[3]/div/div[1]/table/tbody/tr[2]"));
		List<WebElement> selectedRowChilds = selectedRow.findElements(By.xpath(".//*"));
		String oName = selectedRowChilds.get(3).getAttribute("innerHTML");
		String oContact = selectedRowChilds.get(5).getAttribute("innerHTML");
		String oTitle = selectedRowChilds.get(7).getAttribute("innerHTML");
		String oAddress = selectedRowChilds.get(9).getAttribute("innerHTML");
		String oCity = selectedRowChilds.get(11).getAttribute("innerHTML");
		String oCountry = selectedRowChilds.get(13).getAttribute("innerHTML");
		String oPhone = selectedRowChilds.get(15).getAttribute("innerHTML");
		String oEmail = selectedRowChilds.get(17).getAttribute("title");
		String oWebsite = selectedRowChilds.get(20).getAttribute("innerHTML");
		System.out.println("\t\tSelected Data:");
		System.out.println("\t\tName: " + oName);
		System.out.println("\t\tContact: " + oContact);
		System.out.println("\t\tTitle: " + oTitle);
		System.out.println("\t\tAddress: " + oAddress);
		System.out.println("\t\tCity: " + oCity);
		System.out.println("\t\tCountry: " + oCountry);
		System.out.println("\t\tPhone: " + oPhone);
		System.out.println("\t\tEmail: " + oEmail);
		System.out.println("\t\tWebsite: " + oWebsite);
		selectedRowChilds.get(3).click();
		assertThat(driver.findElement(By.id("id")).getAttribute("innerHTML"), is(not("")));

		System.out.println("\t4-Enter Name");
		driver.findElement(By.id("name")).clear();
		driver.findElement(By.id("name")).sendKeys("Rudolph");

		System.out.println("\t5-Enter Contact");
		driver.findElement(By.id("contact")).clear();
		driver.findElement(By.id("contact")).sendKeys("+1 321 321 4321");

		System.out.println("\t6-Enter Title");
		driver.findElement(By.id("title")).clear();
		driver.findElement(By.id("title")).sendKeys("Ms.");

		System.out.println("\t7-Enter Address");
		driver.findElement(By.id("address")).clear();
		driver.findElement(By.id("address")).sendKeys("999 Ninth St.");

		System.out.println("\t8-Enter City");
		driver.findElement(By.id("city")).clear();
		driver.findElement(By.id("city")).sendKeys("Bangkok");

		System.out.println("\t9-Pick Country");
		Select countryDropdown = new Select(driver.findElement(By.id("country")));
		countryDropdown.selectByValue("Thailand");

		System.out.println("\t10-Enter Phone");
		driver.findElement(By.id("phone")).clear();
		driver.findElement(By.id("phone")).sendKeys("+1 321 321 4321");

		System.out.println("\t11-Display Email input text");
		driver.findElement(By.id("email-edit-link")).sendKeys(Keys.ENTER);
		assertThat(driver.findElement(By.id("email")).getCssValue("display"), is(not("none")));

		System.out.println("\t12-Enter Email");
		driver.findElement(By.id("email")).clear();
		driver.findElement(By.id("email")).sendKeys("rudolph@test.com");

		System.out.println("\t13-Display Website input text");
		driver.findElement(By.id("website-edit-link")).sendKeys(Keys.ENTER);
		assertThat(driver.findElement(By.id("website")).getCssValue("display"), is(not("none")));

		System.out.println("\t14-Enter Website");
		driver.findElement(By.id("website")).clear();
		driver.findElement(By.id("website")).sendKeys("www.rudolph.test.com");

		System.out.println("\t15-Enter Comments");
		driver.findElement(By.xpath(".//*[@id='clients_dv_form']/fieldset/div[11]/div/div[2]/div")).clear();
		driver.findElement(By.xpath(".//*[@id='clients_dv_form']/fieldset/div[11]/div/div[2]/div"))
				.sendKeys("No Comment...");

		System.out.println("\t16-Save changes");
		wait.until(ExpectedConditions.elementToBeClickable(By.id("update")));
		driver.findElement(By.id("update")).sendKeys(Keys.ENTER);

		System.out.println("\n17-Verify editing the selected client result");

		System.out.println("\t17.1-Check returned message");
		WebElement messageDiv = driver.findElement(By.xpath("html/body/div[1]/div[3]"));
		List<WebElement> mDivChilds = messageDiv.findElements(By.xpath(".//*"));
		String returnMsg = mDivChilds.get(0).getAttribute("innerHTML");
		System.out.println("\t\tReturned Message:" + returnMsg);
		assertEquals("The changes have been saved successfully.", returnMsg);

		System.out.println("\t17.2-Go back to Clients page and compare data");
		driver.findElement(By.id("deselect")).sendKeys(Keys.ENTER);
		WebElement editedRow = driver
				.findElement(By.xpath("html/body/div[1]/div[4]/div[1]/form/div[3]/div/div[1]/table/tbody/tr[2]"));
		List<WebElement> editedRowChilds = editedRow.findElements(By.xpath(".//*"));
		String nName = editedRowChilds.get(3).getAttribute("innerHTML");
		String nContact = editedRowChilds.get(5).getAttribute("innerHTML");
		String nTitle = editedRowChilds.get(7).getAttribute("innerHTML");
		String nAddress = editedRowChilds.get(9).getAttribute("innerHTML");
		String nCity = editedRowChilds.get(11).getAttribute("innerHTML");
		String nCountry = editedRowChilds.get(13).getAttribute("innerHTML");
		String nPhone = editedRowChilds.get(15).getAttribute("innerHTML");
		String nEmail = editedRowChilds.get(17).getAttribute("title");
		String nWebsite = editedRowChilds.get(20).getAttribute("innerHTML");
		System.out.println("\t\tEdited Data:");
		System.out.println("\t\tName: " + oName + " -> " + nName);
		System.out.println("\t\tContact: " + oContact + " -> " + nContact);
		System.out.println("\t\tTitle: " + oTitle + " -> " + nTitle);
		System.out.println("\t\tAddress: " + oAddress + " -> " + nAddress);
		System.out.println("\t\tCity: " + oCity + " -> " + nCity);
		System.out.println("\t\tCountry: " + oCountry + " -> " + nCountry);
		System.out.println("\t\tPhone: " + oPhone + " -> " + nPhone);
		System.out.println("\t\tEmail: " + oEmail + " -> " + nEmail);
		System.out.println("\t\tWebsite: " + oWebsite + " -> " + nWebsite);
		assertThat(nName, is(not(oName)));
		assertThat(nContact, is(not(oContact)));
		assertThat(nTitle, is(not(oTitle)));
		assertThat(nAddress, is(not(oAddress)));
		assertThat(nCity, is(not(oCity)));
		assertThat(nCountry, is(not(oCountry)));
		assertThat(nPhone, is(not(oPhone)));
		assertThat(nEmail, is(not(oEmail)));
		assertThat(nWebsite, is(not(oWebsite)));
	}

	@After
	public void tearDown() throws Exception {
		driver.quit();
	}
}
